package model.sheet;

import java.util.ArrayList;

import model.data.Data;

/**
 * R�cup�ration des donn�e tri� pour les feuilles excel
 * @author J�r�mie Samson
 * @version 1
 */
public class MonthSheet {
	private int month;
	private ArrayList<Data> listeDataInMonth;
	
	public MonthSheet(int month){
		this.month = month;
		this.listeDataInMonth = new ArrayList<Data>();
	}
	
	//Getters
	public int getMonth(){ return this.month; }
	public ArrayList<Data> getListeDataInMonth() { return listeDataInMonth; }

	//Ajout dans la liste
	public void addDataInMonthSheet(Data data){ this.listeDataInMonth.add(data); }
}
