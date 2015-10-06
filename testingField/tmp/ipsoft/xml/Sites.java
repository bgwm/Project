import javax.xml.*;
import javax.xml.bind.annotation.*;
import java.util.*;

@XmlRootElement
public class Sites {

	List<Site> site;

	public Sites () {
		site = new ArrayList<Site>();
		setSite(new ArrayList<Site>());
		
	}

	public void setSite(List<Site> ites) {
		for (int i=0; i<3; i++)
			site.add(new Site());
	}

	public List<Site> getSite() {
		return this.site;
	}




}
