/** 
 * Name:	Haolong Ning
 * Email:	Ning.Haolong@gmail.com
 */

public class Node {

	private int key;
	private Node leftNode;
	private Node rightNode;
	private Node midNode;
	private boolean isVisited;

	public Node(int key) {
		this.key 	= key;
		this.leftNode 	= null;
		this.rightNode 	= null;
		this.midNode 	= null;
		this.isVisited  = false;
	}

	public boolean isVisited() {
		return this.isVisited;
	}

	public void visit() {
		this.isVisited = true;
	}

	public int getKey() {
		return this.key;
	}

	public void setKey(int value) {
		this.key = value;
	}

	// Add ONE child to CURRENT node, maybe left, right or middle
	public void addChild(Node child) throws TrinaryTreeException {
		if (child == null) return;
		
		if(child.getKey() < this.key)
			leftNode = child;
		else if(child.getKey() > this.key)
			rightNode = child;
		else
			midNode = child;
	}

	public void setLeft(Node left) {
		this.leftNode = left;
	}
	public void setRight(Node right) {
		this.rightNode = right;
	}
	public void setMid(Node mid) {
		this.midNode = mid;
	}

	public boolean hasOnlyChild() {
		int count = 0;	
		if (leftNode != null) count++;
		if (rightNode != null) count++;
		if (midNode != null) count++;
		
		if (count < 2) return true;
		else return false;
	}
	
	/** getChild() should only be called when there is only one child left,
	 *  and method will automatcally return the only child*/
	public Node getChlid() throws TrinaryTreeException {
		if(!hasOnlyChild())
			throw new TrinaryTreeException(
				"getChild() should only be call when" +
				" there is only one child");

		if(leftNode != null) return this.leftNode;
		if(rightNode != null) return this.rightNode;
		if(midNode != null) return this.midNode;
				
		return null;	
	}



	public Node getLeft() {
		return leftNode;
	}

	public Node getRight() {
		return rightNode;
	}

	public Node getMid() {
		return midNode;
	}




}

