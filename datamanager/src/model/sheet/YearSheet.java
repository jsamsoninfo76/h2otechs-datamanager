package model.sheet;

import java.util.ArrayList;

/**
 * R�cup�ration des donn�e tri� pour les feuilles excel
 * 
 * @author Jeremie Samson
 * @version 1
 */
public class YearSheet {
	private String year;
	private ArrayList<MonthSheet> listeMonthSheet; //Date Heure, Value
	
	public YearSheet(String year){
		this.year = year;
		listeMonthSheet = new ArrayList<MonthSheet>();
	}

	//Getters
	public String getYear(){ return year; }
	public ArrayList<MonthSheet> getListeMonthSheet() { return listeMonthSheet;  }

	//Ajout dans la liste
	public void addMonthSheet(MonthSheet monthesheet){ this.listeMonthSheet.add(monthesheet); }
}
