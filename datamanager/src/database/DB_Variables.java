package database;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.HashMap;

import model.databasePojo.Variable;

public class DB_Variables {

	Connection cnx;
	PreparedStatement ps_select;
	PreparedStatement ps_select_all;
	PreparedStatement ps_insert;
	PreparedStatement ps_update;
	PreparedStatement ps_delete;

	public DB_Variables(Connection cnx) {
		this.cnx = cnx;
		try {
			ps_select = cnx
					.prepareStatement("SELECT id_variable,label,description FROM variables WHERE label = ?");
			ps_select_all = cnx.prepareStatement("SELECT * FROM variables");
			ps_insert = cnx
					.prepareStatement("INSERT INTO variables(label) VALUES(?)");
		} catch (SQLException ex) {
			System.out.println(ex);
		}
	}

	public Variable getVariable(String label) {
		Variable variable = null;

		try {
			ps_select.setString(1, label);
			ResultSet rs = ps_select.executeQuery();

			if (rs.next()) {
				int id_variable = rs.getInt("id_variable");
				String description = rs.getString("description");
				variable = new Variable(id_variable, label, description);
			}
		} catch (SQLException ex) {
			System.out.println("DB_Variables SQLException : " + ex);
		}

		return variable;
	}

	public HashMap<String,Integer> getVariables() {
		@SuppressWarnings("unused")
		Variable variable = null;
		HashMap<String,Integer> variables = null;

		try {
			variables = new HashMap<String,Integer>();
			ResultSet rs = ps_select_all.executeQuery();

			while (rs.next()) {
				int id_variable = rs.getInt("id_variable");
				String label = rs.getString("label");
				String description = rs.getString("description");
				variable = new Variable(id_variable, label, description);
				variables.put(label,id_variable);
			}
		} catch (SQLException ex) {
			System.out.println("DB_Variables SQLException : " + ex);
		}

		return variables;
	}

	public void insertVariable(String dirname) {
		try {
			ps_insert.setString(1, dirname);
			ps_insert.executeUpdate();
		} catch (SQLException ex) {
			// System.out.println(ex);
		}
	}
}
