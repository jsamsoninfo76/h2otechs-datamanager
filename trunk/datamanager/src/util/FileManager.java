package util;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;

import javax.swing.JFileChooser;

import model.Model;
import model.data.Data;
import model.data.DataFile;

/**
 * FileManager permet de récupérer le chemin du répertoire a prendre et lie les fichiers ligne par ligne 
 * @author Jérémie Samson
 * @version 1
 * @links
 * http://www.developpez.net/forums/d868887/java/interfaces-graphiques-java/awt-swing/composants/jfilechooser-selection-dossier-uniquement-affichage-fichier-grise/
 * http://javarevisited.blogspot.fr/2011/09/javalangoutofmemoryerror-permgen-space.html
 * http://kohlerm.blogspot.fr/2008/05/analyzing-memory-consumption-of-eclipse.html
 */
public class FileManager {
	private Model model;
	private Data data;
	
	public FileManager(Model model){
		this.model = model;
	}
	
	public File getDir(){
    	JFileChooser dir = new JFileChooser();
        dir.setFileSelectionMode(JFileChooser.DIRECTORIES_ONLY);
        dir.showOpenDialog(null);
    	return dir.getSelectedFile();
    }
	
	/**
	 * Lecture d'un fichier XLS et création des données
	 * @param datadirname 
	 */
	@SuppressWarnings("resource")
	public DataFile readFile(String filename, String datadirname){
		//Création du datafile
		DataFile datafile = new DataFile(filename);
		BufferedReader lect ;
		System.out.println("Traitement de " +filename);
		
		//Lecture du fichier
		try
		{
			lect = new BufferedReader(new FileReader(model.getPath())) ;
			int numLigne = 0;
			
			//Parcours du fichier
			while (lect.ready()==true) 
			{
				String ligne = lect.readLine();
				
				//Supression des caractères inutiles de la première ligne
				if (numLigne == 0) ligne = ligne.substring(2, ligne.length());
				
				if (ligne.length() > 1)
				{
					//Ajout de la donnée
					//datafile.addData(new Data(ligne, datadirname));
					data = new Data(ligne, datadirname);
					model.getDb().getDB_Donnees().insertDonnee(data);
					data = null;
					numLigne++;
				}
			}
		}
		catch (NullPointerException a){
			System.out.println("FileManager.java : NullPointerException " + a);
		}
		catch (IOException a) {
			System.out.println("FileManager.java : IOException " + a);
		}
		
		return datafile;
	}
}