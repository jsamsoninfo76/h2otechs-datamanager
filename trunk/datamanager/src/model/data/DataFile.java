package model.data;

import java.util.ArrayList;

public class DataFile {
	private String filename;
	private ArrayList<Data> listeData;
	
	public DataFile(String filename) {
		this.filename = filename;
		this.listeData = new ArrayList<Data>();
	}

	public String getFilename() {
		return filename;
	}

	public void addData(Data data){
		this.listeData.add(data);
	}
	
	public ArrayList<Data> getListeData() {
		return listeData;
	}
	
	
}
