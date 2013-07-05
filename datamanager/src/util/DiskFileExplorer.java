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
public class DiskFileExplorer {

    private String initialpath = "";
    private Boolean recursivePath = false;
    public int filecount = 0;
    public int dircount = 0;
    public boolean isTest = false;
    private DataManager datamanager;
    private DataDir datadir = null;
    
	/**
	 * Constructeur
	 * @param path chemin du répertoire
	 * @param subFolder analyse des sous dossiers
	 */
    public DiskFileExplorer(String path, Boolean subFolder) {
        super();
        this.initialpath = path;
        this.recursivePath = subFolder;
        this.datamanager = new DataManager();
    }

    public void list() {
        this.listDirectories(this.initialpath);
    }

    private void listDirectories(String dir) {
        File file = new File(dir);
        File[] files = file.listFiles();
        
        if (files != null) {
            for (int i = 0; i < files.length; i++) {
                if (files[i].isDirectory() == true) {
                    //System.out.println("Dossier " + files[i].getAbsolutePath());
                    this.dircount++;
                } else {
                	if (files[i].getName().charAt(0) != '.'){
	                    //System.out.println("Fichier " + files[i].getName() + " index : " + i);
	                    //FileManager filemanager = new FileManager();
		                //datadir.addFile(filemanager.readFile(files[i].getAbsolutePath(), files[i].getName(), datadir.getDirname()));
		                
		                //Ajout du datadir peuplé
		                if (i == files.length-1){
		                	//System.out.println("AJOUT DU DATADIR : " + datadir.getDirname() + " DE TAILLE : " + datadir.getListeFile().size());
		                	datamanager.addDataDir(datadir);
		                }
		                this.filecount++;
                	}
                }
                if (files[i].isDirectory() == true && this.recursivePath == true) {
                	//System.out.println("Chgmt to : " + files[i].getName() + " with index : " + i);
                	datadir = new DataDir(files[i].getName());
                    this.listDirectories(files[i].getAbsolutePath());
                }
            }
        }
    }
    
    public DataManager getDataManager(){
    	return this.datamanager;
    }
}