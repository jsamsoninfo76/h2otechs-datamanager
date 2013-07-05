package model.data;

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
	
	public String getHour() {
		return hour;
	}
	public String getMinute() {
		return minute;
	}
	public String getSeconde() {
		return seconde;
	}
	
	public String toString() {
		//datetime: 2013-07-02 00:00:00
		return hour + ":" + minute + ":" + seconde;
	}
}
