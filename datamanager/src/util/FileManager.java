package util;

import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;

import javax.swing.JFileChooser;

import model.data.Data;
import model.data.DataFile;
import database.DB;
import database.DB_Variables;

/**
 * 
 * @author Spider
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
		DataFile datafile = new DataFile(filename);
		BufferedReader lect ;
		
		try
		{
			lect = new BufferedReader(new FileReader(path)) ;
			int numLigne = 0;
			while (lect.ready()==true) 
			{
				String ligne = "";
				ligne = lect.readLine();
				if (numLigne == 0) ligne = ligne.substring(2, ligne.length());
				
				if (ligne.length() > 1)
				{
					datafile.addData(new Data(ligne, datadirname));
					numLigne++;
				}
			}
		}
		catch (NullPointerException a)
		{
			System.out.println("Erreur : pointeur null");
		}
		catch (IOException a) 
		{
			System.out.println("Problème d'IO");
		}
		
		return datafile;
	}
}