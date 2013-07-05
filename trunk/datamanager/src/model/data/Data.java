package model.data;

/**
 * Simple donnée
 * @author Spider
 *
 */
public class Data {
	private Date date;
	private Time time;
	private String value;
	private String etat;
	private String label;
	
	public Data(Date date, Time time, int idVariable, String value, String etat, String label) {
		this.date = date;
		this.time = time;
		this.value = value;
		this.etat = etat;
		this.label = label;
	}

	public Data(String ligne, String label){
		this.label = label;
		parser(ligne);
	}

	private void parser(String ligne) {
		String tableau[] = null;
		
		//Premiere partie du parse (MM/JJ/AA hh:mm:ss,value,etat)
		tableau = ligne.split(" ");
		this.date = new Date(tableau[0]);
		
		//Deuxieme partie du parse (hh:mm:ss,value,etat)
		tableau = tableau[1].split(",");
		this.time = new Time(tableau[0]);
		this.value = tableau[1];
		this.etat  = tableau[2];
	}
	
	public Date getDate() {
		return date;
	}

	public Time getTime() {
		return time;
	}

	public String getValue() {
		return value;
	}

	public String getEtat() {
		return etat;
	}

	public String getLabel() {
		return label;
	}
	
	public String toString() {
		return date + " " + time + " " + value + " " + etat + " " + label;
	}
	
}
