import javax.xml.*;
import javax.xml.bind.annotation.*;
import java.util.*;

@XmlRootElement
public class Data {

	String name;
	List<xmlData> xs;

	public Data () {
		name = "asdfasf";

		xs = new ArrayList<xmlData>();
		setXs(new ArrayList<xmlData>());

	}

	public String getName() {
		return name;
	}
	public void setName(String name) {
		//this.name = name;
	}

	public void setXs(List<xmlData> xxs) {
		for (int i=0; i<6; i++)
			xs.add (new xmlData());
	}

	public List<xmlData> getXs() {
		return this.xs;
	}

}
