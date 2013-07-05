package database;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;

import model.data.Data;

/**
 * Classe gérant la table donnees
 * @author Jérémie Samson
 * @version 1
 * 
 */
public class DB_Donnees {
	
	  Connection cnx;
	  PreparedStatement ps_select;
	  PreparedStatement ps_insert;
	  
	  public DB_Donnees(Connection cnx) {
	     this.cnx=cnx;
	     try{
	        ps_insert = cnx.prepareStatement("INSERT INTO data_?(id_variable,datetime,valeur,etat) values(?,?,?,?)");
	     } catch(SQLException ex){System.out.println("DB_Donnees.java (DB_Donnees) : SQLException = " +ex);}
	  }
	  
	  public void insertDonnee(Data data, int id_variable){
			try{
				//datetime: 2013-07-02 00:00:00
				ps_insert.setString(1, data.getLabel());
				ps_insert.setInt(2, id_variable);
				ps_insert.setString(3, data.getDate().toString() + " " + data.getTime().toString());
				ps_insert.setString(4, data.getValue());
				ps_insert.setString(5, data.getEtat());
				ps_insert.executeUpdate();
			} catch(SQLException ex){
				System.out.println("DB_Donnees.java (insertDonnee) : SQLException = " + ex);  
			}
	  }
}
