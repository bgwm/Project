import java.util.*;

public class TreeManager {

	private Node root;

	public TreeManager() {
		this.root = null;
	}
	
	public Node getRoot() {
		return this.root;
	}


	// Build Sample Tree, for testing purpose
	public void buildSample() throws TrinaryTreeException {
		root = new Node(5);
		
		// initalize left branch
		root.addChild(new Node(4));
		root.getLeft().addChild(new Node(2));	
		root.getLeft().getLeft().addChild(new Node(2));

		// initalize middle branch
		root.addChild(new Node(5));

		// initalize right branch
		root.addChild(new Node(9));
		root.getRight().addChild(new Node(7));
	}

	public void preorder(Node node) {
		if (node == null) return;
		
		System.out.print(node.getKey() + " ");

		preorder(node.getLeft());
		preorder(node.getMid());
		preorder(node.getRight());
	}

	public void inorder(Node node) {
		if (node == null) return;
		
		inorder(node.getLeft());
		
		System.out.print(node.getKey() + " ");
		
		inorder(node.getMid());
		inorder(node.getRight());
	}

	public void postorder(Node node) {
		if (node == null) return;
		
		postorder(node.getLeft());
		//postorder(node.getMid());
		postorder(node.getRight());

		System.out.print(node.getKey() + " ");
	}

	public void __postorder(Node node) {

		Stack<Node> stack = new Stack<Node> ();
		stack.push(node);

		while(!stack.empty()) {
			Node current = stack.peek();
			if (current.isVisited()) {
				stack.pop();
				System.out.print(current.getKey() + " ");
			} else {
				current.visit();
				if (current.getRight() != null) stack.push(current.getRight());
				if (current.getLeft() != null) stack.push(current.getLeft());
			}
		}
	}

	public void printTree(Node node) {
		System.out.print("\n Preorder:\t");
		preorder(node);

		System.out.print("\n Inorder:\t");
		inorder(node);

		System.out.print("\n postorder:\t");
		postorder(node);

		System.out.println(" ");
	}
	
	public void printTree() {
		if(this.root == null) return;
		
		System.out.print(" Preorder:\t");
		preorder(root);

		System.out.print("\n Inorder:\t");
		inorder(root);

		System.out.print("\n postorder:\t");
		postorder(root);

		System.out.println(" ");
	}

	public void printTree2() {
		if(this.root == null) return;
	
		System.out.print(" Preorder:\t");
		//__preorder(root);

		System.out.print("\n Inorder:\t");
		//__inorder(root);

		System.out.print("\n postorder:\t");
		__postorder(root);

		System.out.println(" ");
	}



	public void insert(int num) throws TrinaryTreeException {

		/** There are two ways to run this code:
		 *    1)  call buildSample() first, which well generate the 
		 *        trinary tree for you;
		 *    2)  WITHOUT calling buildSample(), execute the code 
		 *        from zero;
		 *  1) you don't need to worry about null root; However, if 
		 *  you try to exam the code by 2) path, it will require 
		 *  insert() to handle null root issue.*/
		if(root == null)
			this.root = new Node(num);
		else 
			// root's parent Node is root
			__insert__(root, root, new Node(num)); 
	}

	// Help method for insert()
	public void __insert__ (Node parent, Node current, Node target) 
					throws TrinaryTreeException {

		/** If current is empty, it means we reached the bottom 
		    of the tree; In addition, since the method recursively 
		    reached at this momnent, it also means, *target* should 
		    be the child of current's parent (*parent*), it may be 
		    the left one, right one, or middle one.*/
		if (current == null) {
			parent.addChild(target);
			return;
		}

		// Recursively find out the correct position
		if (current.getKey() > target.getKey())
			__insert__(current, current.getLeft(), target);

		else if (current.getKey() < target.getKey() )
			__insert__(current, current.getRight(), target);
		
		else
			__insert__(current, current.getMid(), target);
	}

	
	public Node getRightMostNode(Node node) {
		if (node.getRight() == null)
			return node;
		else 
			return getRightMostNode(node.getRight());
	}

	private Node __delete__(Node node) throws TrinaryTreeException {
		Node temp;

		if (node.getLeft() == null) 
			node = node.getRight();
		
		else if (node.getRight() == null) 
			node = node.getLeft();
		// What if both children null? --doesn't matter
		
		else {
			temp = getRightMostNode(node.getLeft());
			node.setKey(temp.getKey());
			node.setLeft(delete(node.getKey(), node.getLeft()));
		}
		
		return node;
	}

	public Node delete (int key, Node node) throws TrinaryTreeException {
		if (node == null)
			throw new TrinaryTreeException(
					"Element does not exist");;

		if (key < node.getKey())
			node.setLeft( delete( key, node.getLeft() ) );

		else if (key > node.getKey())
			node.setRight( delete( key, node.getRight() ) );

		else if (node.getMid() != null)
			node.setMid( delete( key, node.getMid() ) );

		else 
			node = __delete__(node);
		return node;
	}

	public void delete(int key) throws TrinaryTreeException {
		root = delete(key, this.root);
	}

	public static void main(String[] args) throws TrinaryTreeException {

		// Initalization
		TreeManager treeManager = new TreeManager();
		treeManager.buildSample();
		treeManager.printTree();
		treeManager.printTree2();

		/** treeManager.delete(5);

		System.out.println("\n----Demonstrate Testing Case-----");
		
		// Case 1: Delete Root without left child
		System.out.println("\n[Case 1: Delete Root without left]");
		treeManager = new TreeManager();
		treeManager.insert(45);
		treeManager.insert(83);
		treeManager.insert(62);
		treeManager.insert(96);
		treeManager.printTree();
		treeManager.delete(45);
		
		System.out.println("(After delete 45):");
		treeManager.printTree();

	
		// Case 2: Delete Root without right child
		System.out.println("\n[Case 2: Delete Root without right]");
		treeManager.delete(96);
		treeManager.insert(63);
		treeManager.insert(45);
		treeManager.printTree();
		treeManager.delete(83);
		
		System.out.println("(After delete 8):");
		treeManager.printTree();
	

		// Case 3: Delete non-root without left child
		System.out.println("\n[Case 3: Delete non-root without left]");
		treeManager.insert(50);
		treeManager.insert(20);
		treeManager.insert(80);
		treeManager.printTree();
		treeManager.delete(63);
		
		System.out.println("(After delete 63):");
		treeManager.printTree();


		// Case 4: Delete non-root without right child
		System.out.println("\n[Case 4: Delete non-root without right]");
		treeManager.insert(70);
		treeManager.printTree();
		treeManager.delete(80);
		
		System.out.println("(After delete 80):");
		treeManager.printTree();


		// Case 5: Delete non-root with left and right child
		System.out.println(
			"\n[Case 5: Delete non-root with left and right]");
		treeManager.insert(65);
		treeManager.insert(80);
		treeManager.printTree();
		treeManager.delete(70);
		
		System.out.println("(After delete 70):");
		treeManager.printTree();


		// Case 6: Delete root with left and right child
		System.out.println(
			"\n[Case 6: Delete root with left and right]");
		treeManager.insert(46);
		treeManager.insert(63);
		treeManager.printTree();
		treeManager.delete(62);
		
		System.out.println("(After delete 62):");
		treeManager.printTree();

	
		// Case 7: Delete root with mid child
		System.out.println(
			"\n[Case 7: Delete root with mid child]");
		System.out.println(
				"** Testing case should contain lots of " +
				"cases with/wtihout middle child; However, " +
				"algorithm always check middle child first, " +
				"and if there is no middle child, back to " + 
				"binary tree case. Therefore, I only give " +
				"one test case of middle child, the rest " + 
				"are similar to above.");
		treeManager.insert(50);
		treeManager.insert(50);
		treeManager.printTree();
		treeManager.delete(50);
		treeManager.delete(50);
		treeManager.delete(50);
		
		System.out.println("(After delete 50):");
		treeManager.printTree();

	
		// Case 8: Delete root without child
		System.out.println(
			"\n[Case 8: Delete root without child]");
		treeManager = new TreeManager();
		treeManager.insert(0);
		treeManager.printTree();
		treeManager.delete(0);
		
		System.out.println("(After delete 0):");
		treeManager.printTree();

		System.out.println("\n-----End of Testing-----\n");	
		
		*/



	}
}	
