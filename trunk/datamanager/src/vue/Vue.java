package vue;

import java.util.Observable;
import java.util.Observer;

import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;

import model.Model;
import controleur.Controler;

public class Vue extends JPanel implements Observer{
	private Model model;
	public JButton assembler, excel, chargerVariable, chargerIntoDB;
	
	public Vue(Model model){
		this.model = model;
		assembler = new JButton("Assembler les fichiers du terminal");
		excel = new JButton("Générer le fichier Excel global");
		excel.setEnabled(false);
		chargerVariable = new JButton("Charger les variables");
		chargerVariable.setEnabled(false);
		chargerIntoDB = new JButton("Charger dans la base de donnée");
		chargerIntoDB.setEnabled(false);
		model.addObserver(this);
		
		this.add(assembler);
		this.add(chargerVariable);
		this.add(excel);
		this.add(chargerIntoDB);
	}

	public void addControler(Controler controler){
		assembler.addActionListener(controler);
		excel.addActionListener(controler);
		chargerVariable.addActionListener(controler);
		chargerIntoDB.addActionListener(controler);
	}
	
	public void update(Observable arg0, Object arg1) {
		
	}
}



