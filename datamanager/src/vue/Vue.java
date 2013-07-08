package vue;

import java.awt.BorderLayout;
import java.awt.FlowLayout;
import java.util.Observable;
import java.util.Observer;

import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JProgressBar;

import model.Model;
import controleur.Controler;

/**
 * Vue respectant le patron de conception MVC
 * 
 * @author Jeremie Samson
 * @version 1
 */
@SuppressWarnings("serial")
public class Vue extends JPanel implements Observer{
	private Model model;
	public JButton assembler, excel, chargerIntoDB;
	private JLabel textInfo;
	public JProgressBar progressBar;
	
	public Vue(Model model){
		this.model = model;
		this.setLayout(new BorderLayout());
		
		//Ajout du text Info
		textInfo = new JLabel("Clickez sur -> Préparer l'insertion");
        textInfo.setHorizontalAlignment(JLabel.CENTER);
        
		//Ajout de la progressBar
		progressBar = new JProgressBar(0, 100);
        progressBar.setValue(0);
        progressBar.setStringPainted(true);
		
		//Création des boutons
        JPanel center = new JPanel(new FlowLayout());
        assembler = new JButton("Préparer l'insertion");
        assembler.setHorizontalAlignment(JButton.CENTER);
        assembler.setVerticalAlignment(JButton.CENTER);
		excel = new JButton("Générer le fichier Excel global");
		//excel.setEnabled(false);
		chargerIntoDB = new JButton("Charger dans la base de donnée");
		chargerIntoDB.setHorizontalAlignment(JButton.CENTER);
		chargerIntoDB.setVerticalAlignment(JButton.CENTER);
		chargerIntoDB.setEnabled(false);
		
		//Ajout de l'observation du model
		model.addObserver(this);
		
		//Ajout au panel
		this.add(textInfo, BorderLayout.NORTH);
		this.add(progressBar, BorderLayout.SOUTH);
		center.add(assembler);
		//this.add(excel);
		center.add(chargerIntoDB);
		this.add(center, BorderLayout.CENTER);
	}

	/**
	 * Ajout des controler aux boutons
	 * @param controler
	 */
	public void addControler(Controler controler){
		assembler.addActionListener(controler);
		//excel.addActionListener(controler);
		chargerIntoDB.addActionListener(controler);
	}
	
	/**
	 * Update de la vue 
	 * @param arg0
	 * @param arg1
	 */
	public void update(Observable arg0, Object arg1) {
		textInfo.setText(model.getTextInfo());
		progressBar.setValue(model.getProgressBarValue());
	}
}