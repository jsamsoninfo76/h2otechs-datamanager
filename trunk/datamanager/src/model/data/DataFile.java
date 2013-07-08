package model.data;

import java.util.ArrayList;

/**
 * POJO DataFile correspondant aux fichier contenu dans les dossiers (D1306250.csv -> DAAMMJJ0 avec D et 0 fixe) _OLD si plus vieux de 2 mois
 * 
 * @author Jeremie Samson
 * @version 1
 */
public class DataFile {
	private String filename;
	private ArrayList<Data> listeData;
	
	public DataFile(String filename) {
		this.filename = filename;
		this.listeData = new ArrayList<Data>();
	}

	//Getters
	public String getFilename() { return filename; }
	public ArrayList<Data> getListeData() { return listeData; }
	
	//Ajout d'une donnée a la liste
	public void addData(Data data){ this.listeData.add(data); }
}
