package model.data;

/**
 * POJO Time correspondant a l'heure, minute et seconde
 * @author Jérémie Samson
 * @version 1 
 */
public class Time {
	private String hour;
	private String minute;
	private String seconde;
	
	public Time(String time) {
		// hh:mm:ss
		String tabTime[] = time.split(":");
 
		this.hour = tabTime[0];
		this.minute = tabTime[1];
		this.seconde = tabTime[2];
	}
	
	//Getters
	public String getHour() { return hour;}
	public String getMinute() { return minute; }
	public String getSeconde() { return seconde; }
	
	//retourne le datetime au format SQL 
	public String toString() {
		return hour + ":" + minute + ":" + seconde;
	}
}
