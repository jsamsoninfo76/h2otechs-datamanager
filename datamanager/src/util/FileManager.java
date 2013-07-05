package util;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;

import javax.swing.JFileChooser;

import model.data.Data;
import model.data.DataFile;

/**
 * FileManager permet de récupérer le chemin du répertoire a prendre et lie les fichiers ligne par ligne 
 * @author Jérémie Samson
 * @version 1
 * @links
 * http://www.developpez.net/forums/d868887/java/interfaces-graphiques-java/awt-swing/composants/jfilechooser-selection-dossier-uniquement-affichage-fichier-grise/
 */
public class FileManager {
	
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
	public DataFile readFile(String path, String filename, String datadirname){
		//Création du datafile
		DataFile datafile = new DataFile(filename);
		BufferedReader lect ;
		
		//Lecture du fichier
		try
		{
			lect = new BufferedReader(new FileReader(path)) ;
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
					datafile.addData(new Data(ligne, datadirname));
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