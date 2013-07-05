package vue;

import java.util.Observable;
import java.util.Observer;

import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;

import model.Model;
import controleur.Controler;

/**
 * Vue respectant le patron de conception MVC
 * @author Jérémie Samson
 * @version 1
 */
@SuppressWarnings("serial")
public class Vue extends JPanel implements Observer{
	private Model model;
	public JButton assembler, excel, chargerIntoDB;
	private JLabel textInfo;
	
	public Vue(Model model){
		this.model = model;
		
		textInfo = new JLabel("Clickez sur Assembler les fichiers");
        
		//Création des boutons
		assembler = new JButton("Assembler les fichiers du terminal");
		excel = new JButton("Générer le fichier Excel global");
		excel.setEnabled(false);
		chargerIntoDB = new JButton("Charger dans la base de donnée");
		chargerIntoDB.setEnabled(false);
		
		//Ajout de l'observation du model
		model.addObserver(this);
		
		//Ajout au panel
		this.add(textInfo);
		this.add(assembler);
		this.add(excel);
		this.add(chargerIntoDB);
	}

	/**
	 * Ajout des controler aux boutons
	 * @param controler
	 */
	public void addControler(Controler controler){
		assembler.addActionListener(controler);
		excel.addActionListener(controler);
		chargerIntoDB.addActionListener(controler);
	}
	
	/**
	 * Update de la vue 
	 * @param arg0
	 * @param arg1
	 */
	public void update(Observable arg0, Object arg1) {
	}
}



