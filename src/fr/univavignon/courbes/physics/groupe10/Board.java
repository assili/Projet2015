package fr.univavignon.courbes.physics.groupe10;
import java.io.Serializable;
import java.util.HashMap;
import java.util.Map;



/**
 * Cette classe correspond à l'ensemble des informations propres à 
 * l'aire de jeu utilisée pendant une manche.
 * <br/>
 * Il faut bien distinguer la notion de partie et de manche. Les joueurs
 * sont confrontés lors d'une parties se déroulant sur plusieurs manches
 * distinctes. À chaque, chaque joueur marque un certain nombre de points.
 * Un joueur gagne la partie quand son score dépasse une certaine valeur
 * limite. 
 */
public class Board implements Serializable
{	/** Numéro de série (pour {@code Serializable}) */
	private static final long serialVersionUID = 1L;
	
	/** Largeur de l'aire de jeu, en pixels */
	public int width;
	/** Hauteur de l'aire de jeu, en pixels */
	public int height;
	
	/** Trainées des snakes sur l'aire de jeu: associe la position d'un pixel à un ID de joueur */
	public Map<Position, Integer> snakesMap;
	/** Tableau contentant tous les snakes de la manche, placés dans l'ordre des ID des joueurs correspondants */
	public Snake snakes[];
	
	/** Position des items sur l'aire de jeu: associe la position d'un item à la valeur de cet item */
	public Map<Position, Item> itemsMap;
	
	public Board(int width, int height)
	{
		this.width = width;
		
		this.height = height;
		
		snakesMap = new HashMap<Position, Integer>();
		
		itemsMap = new HashMap<Position, Item>();
		
	} 
	
	
	public Board init(int width, int height, int[] profileIds)
	{
		/** J'instancie un Board en utilisant le constructeur */
		Board b = new Board(width, height);
		
		/** Le tableau de Snake avec le nombre de nombre de joueur passé en paramétre*/
		b.snakes = new Snake[profileIds.length];
		
		int player_id = 0;
		for (int i = 0; i < profileIds.length; i++)
		{
			b.snakes[i] = new Snake(player_id, profileIds[i], width/(profileIds.length+1)*(i+1), height/2, 1);
		}
		
		
		return b;
	}
	
	
	
	
}
