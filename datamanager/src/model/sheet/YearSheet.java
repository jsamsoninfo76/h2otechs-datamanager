package model.sheet;

import java.util.ArrayList;

public class YearSheet {
	private String year;
	private ArrayList<MonthSheet> listeMonthSheet; //Date Heure, Value
	
	public YearSheet(String year){
		this.year = year;
		listeMonthSheet = new ArrayList<MonthSheet>();
	}

	public String getYear(){
		return year;
	}
	public ArrayList<MonthSheet> getListeMonthSheet() {
		return listeMonthSheet;
	}

	public void addMonthSheet(MonthSheet monthesheet){
		this.listeMonthSheet.add(monthesheet);
	}
	
}
