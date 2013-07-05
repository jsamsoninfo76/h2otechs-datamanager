package model.data;

/**
 * PJO Data récupéré dans les fichiers excel (correspond a une ligne)
 * @author Jérémie Samson
 * @version 1
 */
public class Data {
	private Date date;
	private Time time;
	private String value;
	private int etat;
	private String label;
	
	public Data(String ligne, String label){
		this.label = label;
		parser(ligne);
	}

	private void parser(String ligne) {
		//Suppression des caractères non-ascii
		ligne = ligne.replaceAll("[^\\x20-\\x7e]", "");
		String tableau[] = null;
		
		//Premiere partie du parse (MM/JJ/AA hh:mm:ss,value,etat)
		tableau = ligne.split(" ");
		
		this.date = new Date(tableau[0]);
		
		//Deuxieme partie du parse (hh:mm:ss,value,etat)
		tableau = tableau[1].split(",");
		this.time = new Time(tableau[0]);
		this.value = tableau[1];
		this.etat  = Integer.parseInt(tableau[2]);
	}
	
	//Getters
	public Date getDate() { return date; }
	public Time getTime() { return time; }
	public String getValue() { return value; }
	public int getEtat() { return etat; }
	public String getLabel() { return label; }
	
	public String toString() {
		return date + " " + time + " " + value + " " + etat + " " + label;
	}
	
}
