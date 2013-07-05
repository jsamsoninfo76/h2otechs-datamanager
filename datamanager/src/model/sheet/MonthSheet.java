package model.sheet;

import java.util.ArrayList;

import model.data.Data;

public class MonthSheet {
	private int month;
	private ArrayList<Data> listeDataInMonth;
	
	public MonthSheet(int month){
		this.month = month;
		this.listeDataInMonth = new ArrayList<Data>();
	}
	
	public void addDataInMonthSheet(Data data){
		this.listeDataInMonth.add(data);
	}
	
	public int getMonth(){
		return this.month;
	}

	public ArrayList<Data> getListeDataInMonth() {
		return listeDataInMonth;
	}
}
