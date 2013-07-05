package ui;

import javax.swing.JFrame;

import model.Model;
import vue.Vue;
import controleur.Controler;

/**
 * @author Jeremie Samson
 * @version 1
 * 
 * @Links 
 * http://www.clubnix.fr/book/biblioth%C3%A8que-de-code/java/lire-et-%C3%A9crire-dans-un-fichier-en-java
 * http://www.vogella.com/articles/JavaExcel/
 * 
 */
public class UI extends JFrame {
	
	/**
	 * Constructeur de la classe, lance les methodes d'initialisation pour
	 * construire l'interface graphique.
	 */
	public UI() {
		this.setTitle("H2otechs Assembleur");
		initUI();
		this.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
		this.setResizable(false);
		this.setSize(400,200);
		this.setVisible(true);
	}
	
	/**
	 * Initialise l'interface graphique avec les modèoles, vues et controleurs
	 */
	private void initUI() {
		Model model = new Model();
		Vue vue = new Vue(model);
		Controler controler = new Controler(model, vue);
		vue.addControler(controler);
		this.add(vue);
	}
}
