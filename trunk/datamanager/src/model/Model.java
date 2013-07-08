package model;

import java.util.Observable;

import model.data.DataManager;
import database.DB;
import database.DB_Donnees;
import database.DB_Variables;

/**
 * Model du logiciel
 * 
 * @author Jeremie Samson
 * @version 1
 */
public class Model extends Observable{
	private DataManager datamanager;
	private DB db;
	private DB_Variables db_variables;
	private DB_Donnees db_donnees;
	private String path, textInfo, textInfoTitre;
	private int progressBarValue;
	
	public Model(){
		db = DB.getInstance();
		db_variables = db.getDB_Variables();
		db_donnees 	 = db.getDB_Donnees();
		progressBarValue = 0;
		textInfo = "";
		textInfoTitre = "";
		path = "";
	}
	
	
	//Text infos
	public String getTextInfo() { return textInfo; }
	public void setTextInfo(String textInfo) {
		this.textInfo = textInfo;
		setChanged();
		notifyObservers();
	}
	public String getTextInfoTitre() { return textInfoTitre; }
	public void setTextInfoTitre(String textInfoTitre) {
		this.textInfoTitre = textInfoTitre;
		setChanged();
		notifyObservers();
	}

	//Datamanager
	public DataManager getDatamanager() { return datamanager; }
	public void setDatamanager(DataManager datamanager) { this.datamanager = datamanager; }
	
	//Database
	public DB getDb() { return db; }
	public DB_Variables getDb_variables() { return db_variables; }
	public DB_Donnees getDb_donnees() { return db_donnees; }
	
	//Path
	public String getPath(){ return this.path; }
	public void setPath(String path){ this.path = path;}
	
	//Prograss Bar Value
		public int getProgressBarValue() { return progressBarValue; }
		public void setProgressBarValue(int progressBarValue) {
			this.progressBarValue = progressBarValue;
			setChanged();
			notifyObservers();
		}
}
