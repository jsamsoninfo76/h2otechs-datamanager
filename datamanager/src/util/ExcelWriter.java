package util;

import java.io.File;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Locale;

import jxl.CellView;
import jxl.Workbook;
import jxl.WorkbookSettings;
import jxl.format.UnderlineStyle;
import jxl.write.Label;
import jxl.write.WritableCellFormat;
import jxl.write.WritableFont;
import jxl.write.WritableSheet;
import jxl.write.WritableWorkbook;
import jxl.write.WriteException;
import jxl.write.biff.RowsExceededException;
import model.data.Data;
import model.data.DataDir;
import model.data.DataFile;
import model.data.DataManager;
import model.sheet.MonthSheet;
import model.sheet.YearSheet;

/**
 * Ecrire un fichier excel
 * @author Jérémie Samson
 * @version 1
 * @links 
 * http://www.vogella.com/articles/JavaExcel/
 * http://jexcelapi.sourceforge.net/
 */
public class ExcelWriter {

	private WritableCellFormat timesBoldUnderline;
	private WritableCellFormat times;
	private WritableWorkbook[] workbooks;
	private WritableSheet excelSheet;
	private final String path = "/Users/Spider/Desktop/";
	private ArrayList<String> monthes;
	private DataManager datamanager;
	
	public ExcelWriter(DataManager datamanager) {
		this.datamanager = datamanager;
		monthes = new ArrayList<String>();
		initMonthes();
	}

	/**
	 * Création des fichiers excel (un par année) 1) parcours du datamanager et
	 * récupération des années 2) création des fichiers 3) ajout des mois (un
	 * par feuille)
	 * 
	 * @throws IOException
	 */
	public void createFiles() throws IOException {
		// Initialisation des variables (tableau des années récupérées)
		ArrayList<String> years = new ArrayList<String>();

		// Récupération des années en parcourant le datamanager
		for (DataDir datadir : datamanager.getGloballist()) {
			for (DataFile datafile : datadir.getListeFile()) {
				for (@SuppressWarnings("unused") Data data : datafile.getListeData()) {
					String year = "20" + datafile.getFilename().substring(1, 3);
					if (!years.contains(year))
						years.add(year);
				}
			}
		}
		
		// Initialisation du workbooks
		workbooks = new WritableWorkbook[years.size()];

		// Création des fichiers et des feuilles de mois
		for (String year : years) {
			// Création des fichiers
			File file = new File(path + year + ".xls");
			WorkbookSettings wbSettings = new WorkbookSettings();
			wbSettings.setLocale(new Locale("fr", "FR"));
			WritableWorkbook workbook = Workbook.createWorkbook(file,
					wbSettings);
			workbooks[years.indexOf(year)] = workbook;
			datamanager.addYearSheet((new YearSheet(year)));

			// Création des feuilles
			for (String month : monthes) {
				int indexMonth = monthes.indexOf(month);
				datamanager.getYearsheets().get(years.indexOf(year))
						.addMonthSheet(new MonthSheet(monthes.indexOf(month)+1));
				workbook.createSheet(month, indexMonth);
				excelSheet = workbook.getSheet(indexMonth);

				try {
					createLabel(excelSheet);
				} catch (WriteException e) {
					e.printStackTrace();
				}
			}
		}
	}

	private void initMonthes() {
		monthes.add("Janvier");
		monthes.add("Février");
		monthes.add("Mars");
		monthes.add("Avril");
		monthes.add("Mai");
		monthes.add("Juin");
		monthes.add("Juillet");
		monthes.add("Aout");
		monthes.add("Septembre");
		monthes.add("Octobre");
		monthes.add("Novembre");
		monthes.add("Décembre");
	}
	
	/**
	 * Organisation des données pour rajouter les Data au mois et l'année correspondant
	 */
	public void organizeData() {
		for (DataDir datadir : datamanager.getGloballist()) {
			for (DataFile datafile : datadir.getListeFile()) {
				for (Data data : datafile.getListeData()) {
					for (YearSheet yearsheet : datamanager.getYearsheets()) {
						if (yearsheet.getYear().equalsIgnoreCase("20" + (data.getDate().getYear()))) {
							for (MonthSheet monthsheet : yearsheet .getListeMonthSheet()) {
								//Probleme retour chariot sur le mois & l'année
								String tmp = (monthsheet.getMonth() < 10) ? "0" + monthsheet.getMonth() : String.valueOf(monthsheet.getMonth());
								if (tmp.equalsIgnoreCase(data.getDate().getMonth())){
									monthsheet.addDataInMonthSheet(data);
								}
							}
						}
					}
				}
			}
		}
	}

	/**
	 * Créé les différents intitulés de colonnes des feuilles
	 * 
	 * @param sheet
	 * @throws WriteException
	 */
	private void createLabel(WritableSheet sheet) throws WriteException {
		WritableFont times10pt = new WritableFont(WritableFont.TIMES, 10);
		times = new WritableCellFormat(times10pt);
		times.setWrap(true);

		WritableFont times10ptBoldUnderline = new WritableFont(
				WritableFont.TIMES, 10, WritableFont.BOLD, false,
				UnderlineStyle.SINGLE);
		timesBoldUnderline = new WritableCellFormat(times10ptBoldUnderline);
		timesBoldUnderline.setWrap(true);

		CellView cv = new CellView();
		cv.setFormat(times);
		cv.setFormat(timesBoldUnderline);
		cv.setAutosize(true);

		// Création des titres (tableur, colonne, ligne, valeur)
		addCaption(sheet, 0, 0, "Date");
		addCaption(sheet, 1, 0, "Heure");
		for (DataDir datadir : datamanager.getGloballist()) {
			addCaption(sheet, datamanager.getGloballist().indexOf(datadir) + 2,
					0, datadir.getDirname());
		}
	}

	public void createContents() throws RowsExceededException, WriteException{
		for (int indexworkbook=0 ; indexworkbook<workbooks.length ; indexworkbook++){
			WritableWorkbook workbook = workbooks[indexworkbook];
			YearSheet yearsheet = datamanager.getYearsheets().get(indexworkbook);
			System.out.println("Année : " + yearsheet.getYear());
			
			for (int indexsheet=0 ; indexsheet<workbook.getNumberOfSheets() ; indexsheet++){
				WritableSheet sheet = workbook.getSheet(indexsheet);
				MonthSheet monthsheet = yearsheet.getListeMonthSheet().get(indexsheet);
				System.out.println(yearsheet.getYear() + "/" + monthsheet.getMonth() + " -> "+ sheet.getName());
				
				for (int indexData=0 ; indexData<monthsheet.getListeDataInMonth().size() ; indexData++){
					@SuppressWarnings("unused")
					Data data = monthsheet.getListeDataInMonth().get(indexData);
					//System.out.println("Ajout dans " + sheet.getName() + " col:" + data.getIdVariable() + ", ligne:" + indexData+1 +", value:"+data.getValue());
				//	addLabel(sheet, data.getIdVariable(), indexData+1, data.getValue());
				}
			}
			
			try {
				workbook.write();
				workbook.close();
			} catch (WriteException e) {
				e.printStackTrace();
			} catch (IOException e) {
				e.printStackTrace();
			}	
		}
	}


	private void addCaption(WritableSheet sheet, int column, int row, String s)
			throws RowsExceededException, WriteException {
		Label label;
		label = new Label(column, row, s, timesBoldUnderline);
		sheet.addCell(label);
	}

}
