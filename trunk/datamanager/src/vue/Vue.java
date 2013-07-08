package vue;

import java.awt.BorderLayout;
import java.awt.FlowLayout;
import java.awt.GridLayout;
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
	private JLabel textInfo, textInfoTitre;
	public JProgressBar progressBar;
	
	public Vue(Model model){
		this.model = model;
		this.setLayout(new BorderLayout());
		
		//Ajout du text Info
		JPanel north = new JPanel(new GridLayout(2,1));
		textInfo = new JLabel("Cliquez sur le bouton Préparer l'insertion");
        textInfo.setHorizontalAlignment(JLabel.CENTER);
        textInfoTitre = new JLabel("Préparer l'insertion");
        textInfoTitre.setHorizontalAlignment(JLabel.CENTER);
        north.add(textInfoTitre);
        north.add(textInfo);
        
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
		center.add(assembler);
		center.add(chargerIntoDB);
		
		//Ajout de l'observation du model
		model.addObserver(this);
		
		//Ajout au panel
		this.add(north, BorderLayout.NORTH);
		this.add(progressBar, BorderLayout.SOUTH);
		//this.add(excel);
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
		textInfoTitre.setText(model.getTextInfoTitre());
		progressBar.setValue(model.getProgressBarValue());
	}
}