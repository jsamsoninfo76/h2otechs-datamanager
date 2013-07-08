package vue;

import java.awt.Cursor;
import java.awt.Toolkit;
import java.beans.PropertyChangeEvent;
import java.beans.PropertyChangeListener;
import java.util.Observable;
import java.util.Observer;

import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JProgressBar;
import javax.swing.SwingWorker;

import model.Model;
import model.data.DataDir;
import model.data.DataFile;
import util.FileManager;
import controleur.Controler;

/**
 * Vue respectant le patron de conception MVC
 * 
 * @author Jeremie Samson
 * @version 1
 */
@SuppressWarnings("serial")
public class Vue extends JPanel implements Observer, PropertyChangeListener{
	private Model model;
	public JButton assembler, excel, chargerIntoDB;
	private JLabel textInfo;
	private JProgressBar progressBar;
	private Task task;
	private FileManager filemanager;
	
	public Vue(Model model){
		this.model = model;
		filemanager = new FileManager(model);
		
		//Ajout du text Info
		textInfo = new JLabel("Clickez sur -> Préparer l'insertion");
        
		//Ajout de la progressBar
		progressBar = new JProgressBar(0, 100);
        progressBar.setValue(0);
        progressBar.setStringPainted(true);
		
		//Création des boutons
		assembler = new JButton("Préparer l'insertion");
		excel = new JButton("Générer le fichier Excel global");
		//excel.setEnabled(false);
		chargerIntoDB = new JButton("Charger dans la base de donnée");
		chargerIntoDB.setEnabled(false);
		
		//Ajout de l'observation du model
		model.addObserver(this);
		
		//Ajout au panel
		this.add(textInfo);
		this.add(progressBar);
		this.add(assembler);
		//this.add(excel);
		this.add(chargerIntoDB);
	}

	/**
	 * Ajout des controler aux boutons
	 * @param controler
	 */
	public void addControler(Controler controler){
		assembler.addActionListener(controler);
		//excel.addActionListener(controler);
		chargerIntoDB.addActionListener(controler);
	}
	
	/**
	 * Update de la vue 
	 * @param arg0
	 * @param arg1
	 */
	public void update(Observable arg0, Object arg1) {
	}

	class Task extends SwingWorker<Void, Void> {
        public Void doInBackground() {
            int progress = 0;
            setProgress(0);
            
            int nbFiles = 0;
            for (DataDir datadir:model.getDatamanager().getGloballist()){
				for (int i=0 ; i<datadir.getListeFile().size() ; i++){
					nbFiles++;
				}
			} 
            progressBar.setMaximum(nbFiles);
            
            while (progress < nbFiles) {
            	for (DataDir datadir:model.getDatamanager().getGloballist()){
    				for (DataFile datafile:datadir.getListeFile()){
    					progress++;
    		            setProgress(progress);
    					filemanager.readFile(datafile.getFilename(), datadir.getDirname());
    				}
    			} 
            }
            return null;
        }
 
        public void done() {
            Toolkit.getDefaultToolkit().beep();
            assembler.setEnabled(true);
            setCursor(null); //turn off the wait cursor
            textInfo.setText("Done");
        }
    }

	public void createTask(){
		 assembler.setEnabled(false);
	     setCursor(Cursor.getPredefinedCursor(Cursor.WAIT_CURSOR));
	     task = new Task();
	     task.addPropertyChangeListener(this);
	     task.execute();
	}
	
	public void propertyChange(PropertyChangeEvent evt) {
		if ("progress" == evt.getPropertyName()) {
            int progress = (Integer) evt.getNewValue();
            progressBar.setValue(progress);
            textInfo.setText(String.format(
                    "Completed %d%% of task.\n", task.getProgress()));
        } 
	}
}