package model.data;

import java.util.ArrayList;

public class DataDir {
	private String dirname;
	private ArrayList<DataFile> listeFile;
	
	public DataDir(String dirname) {
		this.dirname = dirname;
		this.listeFile = new ArrayList<DataFile>();
	}

	public String getDirname() {
		return dirname;
	}

	public void addFile(DataFile datafile){
		listeFile.add(datafile);
	}
	
	public ArrayList<DataFile> getListeFile() {
		return listeFile;
	}
}
