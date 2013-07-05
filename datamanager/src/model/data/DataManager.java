package model.data;

import java.util.ArrayList;

import model.sheet.YearSheet;

public class DataManager {
	private ArrayList<YearSheet> yearssheets;
	private ArrayList<DataDir> globallist;
	
	public DataManager(){
		globallist = new ArrayList<DataDir>(); 
		yearssheets = new ArrayList<YearSheet>();
	}

	//GlobalList
	public void addDataDir(DataDir datadir){
		this.globallist.add(datadir);
	}
	public ArrayList<DataDir> getGloballist() {
		return globallist;
	}

	//Yearssheets
	public ArrayList<YearSheet> getYearsheets() {
		return yearssheets;
	}
	public void addYearSheet(YearSheet yearsheet){
		this.yearssheets.add(yearsheet);
	}
}
