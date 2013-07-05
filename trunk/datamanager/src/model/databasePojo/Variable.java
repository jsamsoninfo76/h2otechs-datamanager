package model.databasePojo;

/**
 * POJO Variable correspondant a la DB
 * @author Jérémie Samson
 * @version 1
 */
public class Variable {
	private int id_variable;
	private String label;
	private String description;

	public Variable(int id_variable, String label, String description) {
		super();
		this.id_variable = id_variable;
		this.label = label;
		this.description = description;
	}

	//Getters
	public int getId_variable() { return id_variable; }
	public String getDescription() { return description; }
	public String getLabel() { return label; }
	
	public String toString() {
		return "Variable [id_variable=" + id_variable + ", label=" + label
				+ ", description=" + description + "]";
	}
}
