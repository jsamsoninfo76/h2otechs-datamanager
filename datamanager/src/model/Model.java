package model;

import java.util.Observable;

import model.data.DataManager;
import database.DB;
import database.DB_Donnees;
import database.DB_Variables;

/**
 * Model du logiciel
 * @author Jérémie Samson
 * @version 1
 */
public class Model extends Observable{
	private DataManager datamanager;
	private DB db;
	private DB_Variables db_variables;
	private DB_Donnees db_donnees;
	private String textInfo;
	
	public Model(){
		db = DB.getInstance();
		db_variables = db.getDB_Variables();
		db_donnees 	 = db.getDB_Donnees();
	}
	
	//Text info
	public String getTextInfo() { return textInfo; }
	public void setTextInfo(String textInfo) {
		this.textInfo = textInfo;
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
}
