package model.database;

/**
 * POJO Variable correspondant a la DB
 * 
 * @author Jeremie Samson
 * @version 1
 */
public class Variable {
	private int id_variable;
	private String label;
	private String unite;
	private String description;

	public Variable(int id_variable, String label, String unite, String description) {
		this.id_variable = id_variable;
		this.label = label;
		this.unite = unite;
		this.description = description;
	}
	
	//Getters
	public int getId_variable() { return id_variable; }
	public String getDescription() { return description; }
	public String getUnite() { return unite; }
	public String getLabel() { return label; }

	public String toString() {
		return "Variable [id_variable=" + id_variable + ", label=" + label
				+ ", unite=" + unite + ", description=" + description + "]";
	}
}
