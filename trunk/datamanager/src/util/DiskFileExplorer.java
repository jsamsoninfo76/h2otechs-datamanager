package util;

import java.io.File;

import model.data.DataDir;
import model.data.DataFile;
import model.data.DataManager;

/**
 * Lister le contenu d'un r�pertoire
 * 
 * @author Jeremie Samson
 * @version 1
 * 
 * Sites : 
 * http://www.fobec.com/CMS/java/sources/lister-les-fichiers-les-dossiers-partir-repertoire_964.html (lecture dossier)
 */
public class DiskFileExplorer{
    private String initialpath;
    private Boolean recursivePath;
    public int filecount = 0;
    public int dircount = 0;
    public boolean isTest = false;
    private DataManager datamanager;
    private DataDir datadir;

	/**
	 * Constructeur
	 * @param path chemin du r�pertoire
	 * @param subFolder analyse des sous dossiers
	 */
    public DiskFileExplorer(String path, Boolean subFolder) {
        this.initialpath = path;
        this.recursivePath = subFolder;
        this.datamanager = new DataManager();
    }
    
    /**
     * Fait appelle a la m�thode r�cursive avec le path initial
     */
    public void list() {
    	this.listDirectories(this.initialpath); 	
    }

    /**
     * M�thode r�cursive qui va :
     * 1) lire le dossier
     * 2) lire les sous-dossiers si c'est r�cursif
     * 3) lire les fichiers des sous-dossiers puis enclencher le filemanager
     * 4) peupler le datamanager
     * @param dir dossier a lire
     */
    private void listDirectories(String dir) {
    	//R�cup�ration du dossier / fichier
        File file = new File(dir);
        File[] files = file.listFiles();
        
        if (files != null) {
        	//Boucle sur les fichiers / dossiers si il y en a plusieurs
            for (int i = 0; i < files.length; i++) {
                if (files[i].isDirectory() == true) {
                    this.dircount++;
                } else {
                	//Si ce n'est pas un fichier cacher (pour �viter les .DS_ sous mac
                	if (files[i].getName().charAt(0) != '.'){
                		//Ajout du fichier dans l'objet DataDir correspondant avec (path, nom fichier, nom dossier)  
                		DataFile datafile = new DataFile(files[i].getName());
                		datadir.addFile(datafile);
                		
		                //Ajout du datadir termin�
		                if (i == files.length-1)
		                	datamanager.addDataDir(datadir);
		                
		                this.filecount++;
                	}
                }
                
                //R�cursivit� sur les sous dossiers
                if (files[i].isDirectory() == true && this.recursivePath == true) {
                	datadir = new DataDir(files[i].getName());
                    this.listDirectories(files[i].getAbsolutePath());
                }
            }
        }
    }
    
    /**
     * R�cup�ration du datamanager
     * @return datamanager
     */
    public DataManager getDataManager(){ return this.datamanager; }
}