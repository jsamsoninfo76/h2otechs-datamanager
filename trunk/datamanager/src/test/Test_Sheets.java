package test;

import model.Model;
import model.data.DataManager;
import model.sheet.MonthSheet;
import model.sheet.YearSheet;

/**
 * Test_sheets pour les tests sur les fichiers / feuilles
 * @author Jérémie Samson
 * @version 1
 */
public class Test_Sheets extends Test{
	
	public Test_Sheets(DataManager datamanager, Model model) {
		super(datamanager, model);
	}

	private void testYearsSheets() {
		System.out.println("--------------------------------------");
		System.out.println("Nombre de YearSheet : " + datamanager.getYearsheets().size());
		for (YearSheet yearsheet:datamanager.getYearsheets()){
			System.out.println("[" + yearsheet.getYear() + "] mois : " + yearsheet.getListeMonthSheet().size());
		}
	}
	
	private void testMonthesSheets() {
		int nbMonthSheet = 0;
		for (YearSheet yearsheet:datamanager.getYearsheets()){
			for (int i=0 ; i<yearsheet.getListeMonthSheet().size() ; i++){
				nbMonthSheet++;
			}
		}
		
		System.out.println("Nombre de MonthSheet : " + nbMonthSheet);
		for (YearSheet yearsheet:datamanager.getYearsheets()){
			for (MonthSheet monthsheet:yearsheet.getListeMonthSheet()){
				System.out.println("[" + yearsheet.getYear() + "/" + ((monthsheet.getMonth()<10) ? "0"+monthsheet.getMonth() : monthsheet.getMonth()) + "] datas : " + monthsheet.getListeDataInMonth().size());
			}
		}
	}
	
	public void test(){
		testYearsSheets();
		testMonthesSheets();
	}
}
