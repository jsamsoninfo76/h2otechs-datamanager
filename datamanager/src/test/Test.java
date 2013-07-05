package test;

import model.Model;
import model.data.DataManager;

public class Test {
	protected DataManager datamanager;
	protected Model model;
	
	public Test(DataManager datamanager, Model model){
		this.datamanager = datamanager;
		this.model = model;
	}
	
	public void test(){
		Test_Files test_files = new Test_Files(datamanager, model);
		test_files.test();
		
		Test_Datas test_dates = new Test_Datas(datamanager, model);
		test_dates.test();
		
		Test_DB test_db = new Test_DB(datamanager, model);
		test_db.test();
		
		Test_Sheets test_sheets = new Test_Sheets(datamanager, model);
		test_sheets.test();
	}
}
