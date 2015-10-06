import javax.xml.*;
import javax.xml.bind.annotation.*;

@XmlRootElement
public class Site {

	Hosts hosts;

	public Site () {
		hosts = new Hosts();
	}

	public void setHosts(Hosts h) {
	}

	public Hosts getHosts() {
		return this.hosts;
	}

		
}
