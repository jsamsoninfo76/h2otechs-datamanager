package model.data;

import java.util.ArrayList;

import model.sheet.YearSheet;

/**
 * DataManager regroupe les listes importante pour la génération excel et l'ajout dans la DB
 * 
 * @author Jeremie Samson
 * @version 1
 */
public class DataManager {
	private ArrayList<YearSheet> yearssheets;
	private ArrayList<DataDir> globallist;
	
	public DataManager(){
		globallist = new ArrayList<DataDir>(); 
		yearssheets = new ArrayList<YearSheet>();
	}

	//Getters
	public ArrayList<DataDir> getGloballist() { return globallist; }
	public ArrayList<YearSheet> getYearsheets() { return yearssheets; }
	
	//Ajouts
	public void addDataDir(DataDir datadir){ this.globallist.add(datadir); }
	public void addYearSheet(YearSheet yearsheet){ this.yearssheets.add(yearsheet); }
}
