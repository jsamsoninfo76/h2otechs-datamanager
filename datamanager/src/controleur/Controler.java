package controleur;

import java.awt.Cursor;
import java.awt.Toolkit;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.beans.PropertyChangeEvent;
import java.beans.PropertyChangeListener;
import java.io.File;
import java.io.IOException;

import javax.swing.JButton;
import javax.swing.JOptionPane;
import javax.swing.SwingWorker;

import jxl.write.WriteException;
import jxl.write.biff.RowsExceededException;
import model.Model;
import model.data.DataDir;
import model.data.DataFile;
import util.DiskFileExplorer;
import util.ExcelWriter;
import util.FileManager;
import vue.Vue;

/**
 * Controleur de l'UI
 * 
 * @author Jeremie Samson
 * @version 1
 */
public class Controler implements ActionListener, PropertyChangeListener{
	
	private Model model;
	private Vue vue;
	private Task task;
	private FileManager filemanager;
	
	public Controler(Model model, Vue vue){
		this.model = model;
		this.vue = vue;
		filemanager = new FileManager(model);
	}
	/**
	 * Action sur leq bouton assembleur, charger les variables, charger dans la base de données, génération excel
	 */
	public void actionPerformed(ActionEvent arg0) {
		
		JButton event = (JButton) arg0.getSource();
		if (event == vue.assembler){
			//Récupération du dossier a assembler 
			File dir = new File("/Users/Spider/Desktop/LOG/");
			model.setPath(dir.getPath());
			
			//File dir = new File(model.getPath());
			//model.setPath(dir.getAbsolutePath());
			
			if (dir != null){
				//Nom valide : projects, cible1, log, data
				if (isDirValide(dir.getName())){			        
					//On va ouvrir le dossier et ses sous dossiers
					DiskFileExplorer diskFileExplorer = new DiskFileExplorer(dir.getAbsolutePath(), true);
					diskFileExplorer.list();
					
					//Récupération du datamanager
					model.setDatamanager(diskFileExplorer.getDataManager());
					model.setTextInfoTitre("Insertion prête");
					model.setTextInfo("Clickez sur Charger dans la base de donnée");
					//JOptionPane.showMessageDialog(null, "Chargement terminé", "Message Informatif", JOptionPane.INFORMATION_MESSAGE);
				}
				else
					JOptionPane.showMessageDialog(null, "Le répertoire selectionné doit être un répertoire converti issu du terminal (PROJECTS,CIBLE1,DATA ou LOGS)", "Message Informatif", JOptionPane.INFORMATION_MESSAGE);
			}
			
			//Changement d'état des autres boutons
			vue.excel.setEnabled(true);
			vue.chargerIntoDB.setEnabled(true);
		}
		else if (event == vue.chargerIntoDB){
			vue.chargerIntoDB.setEnabled(false);
			createTask();
		}
		else if (event == vue.excel){
			//On va venir créer un fichier excel sous la forme Fichier (année) avec feuilles (une par mois) et données 
			try {
				ExcelWriter out = new ExcelWriter(model.getDatamanager());
				out.createFiles();
				out.organizeData();
				out.createContents();
				
			} catch (IOException e) {
				e.printStackTrace();
			} catch (RowsExceededException e) {
				e.printStackTrace();
			} catch (WriteException e) {
				e.printStackTrace();
			}
		}
	}
	
	/**
	 * Vérifie si le répertoire est correct
	 * @param filename
	 * @return boolean
	 */
	private boolean isDirValide(String filename){
		if (filename.equalsIgnoreCase("projects")) return true;
		else if (filename.equalsIgnoreCase("cible1")) return true;
		else if (filename.equalsIgnoreCase("data")) return true;
		else if (filename.equalsIgnoreCase("log")) return true;
		else return false;
	}
	
	/**
	 * Sous classe Task utilisé pour la JProgressBar
	 */
	class Task extends SwingWorker<Void, Void> {
		
		/**
		 * Lance le chargement des données dans la DB
		 */
        public Void doInBackground() {
            int progress = 0;
            setProgress(0);
            
            int nbFiles = 0;
            for (DataDir datadir:model.getDatamanager().getGloballist()){
				for (int i=0 ; i<datadir.getListeFile().size() ; i++){
					nbFiles++;
				}
			} 
            vue.progressBar.setMaximum(nbFiles);
            
            while (progress < nbFiles) {
            	for (DataDir datadir:model.getDatamanager().getGloballist()){
    				for (DataFile datafile:datadir.getListeFile()){
    					progress++;
    		            if (progress != nbFiles) setProgress(progress);
    					filemanager.readFile(datafile.getFilename(), datadir.getDirname());
    				}
    			} 
            }
            vue.chargerIntoDB.setEnabled(true);
            setProgress(nbFiles);
            return null;
        }
 
        /**
         * Appelé quand terminé
         */
        public void done() {
            Toolkit.getDefaultToolkit().beep();
            vue.assembler.setEnabled(true);
            vue.setCursor(null); //turn off the wait cursor
            model.setTextInfoTitre("");
            model.setTextInfo("Insertion dans la base de donnée terminé.");
        }
    }

	/**
	 * Créé la tache et l'execute
	 */
	public void createTask(){
		 vue.assembler.setEnabled(false);
	     vue.setCursor(Cursor.getPredefinedCursor(Cursor.WAIT_CURSOR));
	     task = new Task();
	     task.addPropertyChangeListener(this);
	     task.execute();
	}
	
	/**
	 * Change la progression de la bar
	 */
	public void propertyChange(PropertyChangeEvent evt) {
		if ("progress" == evt.getPropertyName()) {
            int progress = (Integer) evt.getNewValue();
            model.setProgressBarValue(progress);
        } 
	}
}
