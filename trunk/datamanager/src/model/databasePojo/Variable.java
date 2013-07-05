package model.databasePojo;

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

	public int getId_variable() {
		return id_variable;
	}

	public void setId_variable(int id_variable) {
		this.id_variable = id_variable;
	}

	public String getLabel() {
		return label;
	}

	public void setLabel(String label) {
		this.label = label;
	}

	public String getDescription() {
		return description;
	}

	public void setDescription(String description) {
		this.description = description;
	}

	public String toString() {
		return "Variable [id_variable=" + id_variable + ", label=" + label
				+ ", description=" + description + "]";
	}

}
