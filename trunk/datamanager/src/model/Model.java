package model;

import java.util.Observable;

import model.data.DataManager;

import database.DB;
import database.DB_Donnees;
import database.DB_Variables;

public class Model extends Observable{
	private DataManager datamanager;
	private DB db = DB.getInstance();
	private DB_Variables db_variables = db.getDB_Variables();
	private DB_Donnees db_donnees = db.getDB_Donnees();

	public Model() {}
	
	public DataManager getDatamanager() {
		return datamanager;
	}

	public void setDatamanager(DataManager datamanager) {
		this.datamanager = datamanager;
	}
	
	public DB getDb() {
		return db;
	}

	public DB_Variables getDb_variables() {
		return db_variables;
	}
	
	public DB_Donnees getDb_donnees() {
		return db_donnees;
	}
}
