package test;

import java.util.HashMap;

import model.Model;
import model.data.Data;
import model.data.DataDir;
import model.data.DataFile;
import model.data.DataManager;
import model.databasePojo.Variable;

public class Test_DB extends Test{
	
	private HashMap<String, Integer> listVariables;
	
	public Test_DB(DataManager datamanager, Model model) {
		super(datamanager, model);
	}

	private void testDBConnection(){
		model.getDb();
	}
	
	private void testInsertVariable(){
		model.getDb_variables().insertVariable("TEST");
		if (model.getDb_variables().getVariable("TEST") != null)
			System.out.println("Insertion OK");
		else
			System.out.println("Inserton Erreur");
	}

	public void test(){
		testDBConnection();
		//testInsertVariable();
	}
}
