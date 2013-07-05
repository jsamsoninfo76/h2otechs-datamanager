package model.data;

import java.util.ArrayList;

/**
 * POJO DataDir regroupant les noms de répertoire (correspondant aux variables) et les fichiers contenant les données)
 * @author Jérémie Samson
 * @version 1
 */
public class DataDir {
	private String dirname;
	private ArrayList<DataFile> listeFile;
	
	public DataDir(String dirname) {
		this.dirname = dirname;
		this.listeFile = new ArrayList<DataFile>();
	}

	//Getter
	public String getDirname() { return dirname; }
	public ArrayList<DataFile> getListeFile() {	return listeFile; }
	
	//Ajout d'un dosier a la liste
	public void addFile(DataFile datafile){ listeFile.add(datafile); }
}
