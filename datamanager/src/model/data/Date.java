package model.data;

/**
 * POJO Date avec l'année, le mois et le jours
 * 
 * @author Jeremie Samson
 * @version 1
 */
public class Date {
	private String year;
	private String month;
	private String day;
	
	public Date(String date) {
		// date correspond à -> MM/JJ/AA
		String tabDate[] = date.split("/");
		
		// Retour chariot empechait bon fonctionnement trim puis récupération des bon caractères
		this.year = "20" + tabDate[2]; 
		this.month = tabDate[0];
		this.day = tabDate[1];
	}

	//Getters
	public String getYear() { return year; }
	public String getMonth() { return month; }
	public String getDay() { return day; }
	
	//retourne le datetime au format SQL : 01-14-2013
	public String toString() {
		return month + "-" + day + "-" + year;
	}	
}
