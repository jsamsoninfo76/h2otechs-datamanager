package database;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;

import model.data.Data;

public class DB_Donnees {
	
	  Connection cnx;
	  PreparedStatement ps_select;
	  PreparedStatement ps_insert;
	  PreparedStatement ps_update;
	  PreparedStatement ps_delete;

	  public DB_Donnees(Connection cnx) {
	     this.cnx=cnx;
	     try{
	        //ps_select = cnx.prepareStatement("SELECT id_donnee,id_variable,valeur,etat,date_ajout FROM donnees WHERE id_donnee = ?");
	  	    ps_insert = cnx.prepareStatement("INSERT INTO donnees(id_variable,datetime,valeur,etat) values(?,?,?,?)");
	        //ps_update = cnx.prepareStatement("UPDATE donnees SET id_variable=?, datetime=?, valeur=?, etat=?  WHERE id_donnee=?");
	        //ps_delete = cnx.prepareStatement("DELETE FROM donnees WHERE id_donnee=?"); 
	     } catch(SQLException ex){System.out.println(ex);}
	  }
	  
	  public void insertDonnee(Data data, int id_variable){
			try{
				ps_insert.setInt(1, id_variable);
				//datetime: 2013-07-02 00:00:00
				ps_insert.setString(2, data.getDate().toString() + " " + data.getTime().toString());
				ps_insert.setString(3, data.getValue());
				ps_insert.setString(4, data.getEtat());
				ps_insert.executeUpdate();
			} catch(SQLException ex){
				System.out.println(ex);  
			}
	  }
}
