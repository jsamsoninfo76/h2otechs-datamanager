package util;

import java.io.File;

import model.data.DataDir;
import model.data.DataManager;

/**
 * Lister le contenu d'un répertoire
 * @author Jérémie Samson
 * @version 1
 * @links
 * http://www.fobec.com/CMS/java/sources/lister-les-fichiers-les-dossiers-partir-repertoire_964.html
 */
public class DiskFileExplorer{
    private String initialpath = "";
    private Boolean recursivePath = false;
    public int filecount = 0;
    public int dircount = 0;
    public boolean isTest = false;
    private DataManager datamanager;
    private DataDir datadir;
    private FileManager filemanager;
    
	/**
	 * Constructeur
	 * @param path chemin du répertoire
	 * @param subFolder analyse des sous dossiers
	 */
    public DiskFileExplorer(FileManager filemanager, String path, Boolean subFolder) {
        this.initialpath = path;
        this.recursivePath = subFolder;
        this.datamanager = new DataManager();
        this.filemanager = filemanager;
    }
    
    /**
     * Fait appelle a la méthode récursive avec le path initial
     */
    public void list() {
    	this.listDirectories(this.initialpath); 	
    }

    /**
     * Méthode récursive qui va :
     * 1) lire le dossier
     * 2) lire les sous-dossiers si c'est récursif
     * 3) lire les fichiers des sous-dossiers puis enclencher le filemanager
     * 4) peupler le datamanager
     * @param dir dossier a lire
     */
    private void listDirectories(String dir) {
    	//Récupération du dossier / fichier
        File file = new File(dir);
        File[] files = file.listFiles();
        
        if (files != null) {
        	//Boucle sur les fichiers / dossiers si il y en a plusieurs
            for (int i = 0; i < files.length; i++) {
                if (files[i].isDirectory() == true) {
                    this.dircount++;
                } else {
                	//Si ce n'est pas un fichier cacher (pour éviter les .DS_ sous mac
                	if (files[i].getName().charAt(0) != '.'){
                		//Ajout du fichier dans l'objet DataDir correspondant avec (path, nom fichier, nom dossier)  
		                //datadir.addFile(filemanager.readFile(files[i].getAbsolutePath(), files[i].getName(), datadir.getDirname()));
                		filemanager.readFile(files[i].getAbsolutePath(), files[i].getName(), datadir.getDirname());
		                //Ajout du datadir terminé
		               // if (i == files.length-1)
		               // 	datamanager.addDataDir(datadir);
		                
		                this.filecount++;
                	}
                }
                
                //Récursivité sur les sous dossiers
                if (files[i].isDirectory() == true && this.recursivePath == true) {
                	datadir = new DataDir(files[i].getName());
                    this.listDirectories(files[i].getAbsolutePath());
                }
            }
        }
    }
    
    /**
     * Récupération du datamanager
     * @return datamanager
     */
    public DataManager getDataManager(){ return this.datamanager; }
}