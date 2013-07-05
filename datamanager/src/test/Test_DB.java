package test;

import model.Model;
import model.data.DataManager;

/**
 * Test_DB test la base de donnée (connexion, insertion)
 * @author Jérémie Samson
 * @version 1
 */
public class Test_DB extends Test{
	
	public Test_DB(DataManager datamanager, Model model) {
		super(datamanager, model);
	}

	private void testDBConnection(){
		model.getDb();
	}
	
	/* private void testInsertVariable(){
		model.getDb_variables().insertVariable("TEST");
		if (model.getDb_variables().getVariable("TEST") != null)
			System.out.println("Insertion OK");
		else
			System.out.println("Inserton Erreur");
	}*/

	public void test(){
		testDBConnection();
		//testInsertVariable();
	}
}
