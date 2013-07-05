package test;

import model.Model;
import model.data.DataDir;
import model.data.DataManager;

/**
 * Test_files test le nombre de dossiers et de fichiers a charger
 * @author Jérémie Samson
 * @version 1
 */
public class Test_Files extends Test{
	
	public Test_Files(DataManager datamanager, Model model) {
		super(datamanager, model);
	}

	private void testDossiers(){
		System.out.println("Nombre Dossiers : " + datamanager.getGloballist().size());
	}
	
	private void testFichiers(){
		int nbFichiers = 0;
		for (DataDir datadir:datamanager.getGloballist()){
			for (int i=0 ; i<datadir.getListeFile().size() ; i++){
				nbFichiers++;
			}
		}
		
		System.out.println("Nombre Fichiers : " + nbFichiers);
	}

	public void test(){
		testDossiers();
		testFichiers();
	}
}
