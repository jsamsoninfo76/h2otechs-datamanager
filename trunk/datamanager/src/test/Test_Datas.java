package test;

import model.Model;
import model.data.DataDir;
import model.data.DataFile;
import model.data.DataManager;

public class Test_Datas extends Test{

	public Test_Datas(DataManager datamanager, Model model) {
		super(datamanager, model);
	}
	
	private void testDatas(){
		int nbDatas = 0;
		for (DataDir datadir:datamanager.getGloballist()){
			for (DataFile datafile:datadir.getListeFile()){
				nbDatas += datafile.getListeData().size();
			}
		}
		
		System.out.println("Nombre Datas : " + nbDatas);
	}
	
	public void test(){
		testDatas();
		
	}
}
