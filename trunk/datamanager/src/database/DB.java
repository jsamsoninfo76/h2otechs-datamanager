package database;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class DB {
	private static DB instance;
	Connection conn;
	
	//Instenciation
	DB_Donnees db_donnees;
	DB_Variables db_variables;
	
	public static DB getInstance(){
		if (null == instance){instance=new DB();}
		return instance;
	}
	
	public DB(){
		try {
			Class.forName("com.mysql.jdbc.Driver");
			//System.out.println("Driver OK");
		}catch (ClassNotFoundException e) {e.printStackTrace();}
		
		try {
			String url = "jdbc:mysql://localhost:8889/h2otechs_datamanager";
			String user = "root";
			String passwd = "root";
			
			conn = DriverManager.getConnection(url, user, passwd);
			
			//Initialisation after connexion
			db_donnees = new DB_Donnees(conn);
			db_variables = new DB_Variables(conn);
			
			//System.out.println("Connection OK");
		}catch (SQLException e) {e.printStackTrace();} 
	}
	
	//Getters
	public DB_Donnees getDB_Donnees(){return db_donnees;}
	public DB_Variables getDB_Variables(){return db_variables;}
}
