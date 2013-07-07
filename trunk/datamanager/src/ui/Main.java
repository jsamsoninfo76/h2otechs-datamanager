package ui;

/**
 * Main lance l'application.
 * 
 * @author Jeremie Samson
 * @version 1
 */
public class Main {
	public static void main(String[] args) {
		javax.swing.SwingUtilities.invokeLater(new Runnable() {
			public void run() {
				new UI();
			}
		});
	}
}
