package fr.univavignon.courbes.network.central;

import java.sql.*;

public class BD
{
	
	private static final String DRIVER = "org.postgresql.Driver";
	/**
	 *Url de connection sur le serveur 
	 */
	private static final String URL = "jdbc:postgresql://pedago02a.univ-avignon.fr:5432/etd";
	/**
	 * Le login de l'utilisateur qui veut se connecter
	 */
	private static final String NAME = "uapv1200086";
	/**
	 * Le mot de passe de l'utilisateur qui veut se connecter
	 */
	private static final String PASS = "K42Y4Z";
	
	/**
	 * @return Connection
	 * @see Connection
	 */
	public static Connection Connecte()
	{
		try {
			Class.forName(DRIVER);
			try {
				Connection con = DriverManager.getConnection(URL, NAME, PASS);
			return con;
			} catch (SQLException e) {
				// TODO Auto-generated catch block
			}
		} catch (ClassNotFoundException e) {
			// TODO Auto-generated catch block
		}
		return null;
	}
}