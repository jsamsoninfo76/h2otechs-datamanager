package database;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;

import model.data.Data;

/**
 * Classe gérant la table donnees
 * 
 * @author Jeremie Samson
 * @version 1
 * 
 * Sites :
 * http://thunderguy.com/semicolon/2003/08/14/java-sql-date-is-not-a-real-date/ (String to SQL)
 * http://www.siteduzero.com/forum/sujet/convertir-une-chaine-en-date-72853 (String to SQL)
 */
public class DB_Donnees {
	
	  Connection cnx;
	  PreparedStatement ps_select;
	  PreparedStatement ps_insert;
	  
	  public DB_Donnees(Connection cnx) {
	     this.cnx=cnx;
	  }
	  
	  public void insertDonnee(Data data){
			try{
				ps_insert = cnx.prepareStatement("INSERT INTO data_" +data.getLabel()+ "(datetime,value,state) values(?,?,?)");
				ps_insert.setTimestamp(1, toDBDateFormat(data.getDate() + " " + data.getTime()));
				ps_insert.setString(2, data.getValue());
				ps_insert.setInt(3, data.getEtat());
				ps_insert.executeUpdate();
				System.out.println("Insertion de [" + data + "] effectué.");
			} catch(SQLException ex){
				System.out.println("DB_Donnees.java (insertDonnee) : SQLException = " + ex);  
			} catch (ParseException e) {
				System.out.println("DB_Donnees.java (insertDonnee) : ParseException = " + e);
			}
	  }
	  
	  public static Date stringToDate(String sDate) throws ParseException {
		  	SimpleDateFormat formatter = new SimpleDateFormat("MM-dd-yyyy HH:mm:ss");
	        return formatter.parse(sDate);
	  }
	     
	  public static Timestamp toDBDateFormat(String sDate) throws ParseException {
	      return new Timestamp(stringToDate(sDate).getTime());
	  }
}
