import javax.xml.*;
import javax.xml.bind.annotation.*;
import java.util.*;

@XmlRootElement
public class Hosts {

	String name;
	List<Host> host;

	public Hosts() {
		name = "saf";
		host = new ArrayList<Host>();
		setHost(new ArrayList<Host>());
	}

	public void setName(String name) {

	}

	public String getName() {
		return this.name;
	}
	
	public void setHost(List<Host> h) {
		for (int i=0; i<2; i++)
			host.add(new Host());
	}

	public List<Host> getHost() {
		return this.host;
	}



}
