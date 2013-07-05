package model.data;

/**
 * POJO Date avec l'année, le mois et le jours
 * @author Jérémie Samson
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
		tabDate[0] = tabDate[0].trim();
		tabDate[1] = tabDate[1].trim();
		tabDate[2] = tabDate[2].trim();
		this.year = "20" + tabDate[2].charAt(0) + "" + tabDate[2].charAt(2) ; 
		this.month = tabDate[0].charAt(0) + "" + tabDate[0].charAt(2) ;
		this.day = tabDate[1].charAt(0) + "" + tabDate[1].charAt(2) ;
	}

	//Getters
	public String getYear() { return year; }
	public String getMonth() { return month; }
	public String getDay() { return day; }
	
	//retourne le datetime au format SQL : 2013-07-02
	public String toString() {
		return year + "-" + month + "-" + day;
	}	
}
