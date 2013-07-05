package controleur;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.File;
import java.io.IOException;
import java.util.HashMap;

import javax.swing.JButton;
import javax.swing.JOptionPane;

import jxl.write.WriteException;
import jxl.write.biff.RowsExceededException;
import model.Model;
import model.data.Data;
import model.data.DataDir;
import model.data.DataFile;
import util.DiskFileExplorer;
import util.ExcelWriter;
import util.FileManager;
import vue.Vue;

/**
 * Controleur de l'UI
 * 
 * @author J�r�mie Samson
 * @version 1
 */
public class Controler implements ActionListener {
	
	@SuppressWarnings("unused")
	private final FileManager filemanager = new FileManager();
	private Model model;
	private Vue vue;
	
	public Controler(Model model, Vue vue){
		this.model = model;
		this.vue = vue;
	}
	/**
	 * Action sur leq bouton assembleur, charger les variables, charger dans la base de donn�es, g�n�ration excel
	 */
	public void actionPerformed(ActionEvent arg0) {
		
		JButton event = (JButton) arg0.getSource();
		if (event == vue.assembler){
			//R�cup�ration du dossier a assembler 
			//File dir = filemanager.getDir();
			File dir = new File("/Users/Spider/PROJECTS");
			
			if (dir != null){
				//Nom valide : projects, cible1, log, data
				if (isDirValide(dir.getName())){
					//On va ouvrir le dossier et ses sous dossiers
					DiskFileExplorer diskFileExplorer = new DiskFileExplorer(dir.getAbsolutePath(), true);
					diskFileExplorer.list();
					
					//R�cup�ration du datamanager
					model.setDatamanager(diskFileExplorer.getDataManager());
					JOptionPane.showMessageDialog(null, "Chargement termin�", "Message Informatif", JOptionPane.INFORMATION_MESSAGE);
				}
				else
					JOptionPane.showMessageDialog(null, "Le r�pertoire selectionn� doit �tre un r�pertoire converti issu du terminal (PROJECTS,CIBLE1,DATA ou LOGS)", "Message Informatif", JOptionPane.INFORMATION_MESSAGE);
			}
			
			//Changement d'�tat des autres boutons
			vue.excel.setEnabled(true);
			vue.chargerIntoDB.setEnabled(true);
		}
		else if (event == vue.chargerIntoDB){
			//On charge toutes les donners dans la base
			HashMap<String, Integer> listVariables = model.getDb_variables().getVariables();
			
			for (DataDir datadir:model.getDatamanager().getGloballist()){
				for (DataFile datafile:datadir.getListeFile()){
					for (Data data:datafile.getListeData()){
						model.getDb_donnees().insertDonnee(data, listVariables.get(data.getLabel()));
					}
				}
			}
		}
		else if (event == vue.excel){
			//On va venir cr�er un fichier excel sous la forme Fichier (ann�e) avec feuilles (une par mois) et donn�es 
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
	 * V�rifie si le r�pertoire est correct
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
}
