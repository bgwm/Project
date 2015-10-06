import javax.xml.bind.annotation.*;

@XmlRootElement
public class xmlData {
	String xmlName;
	public xmlData () {
		xmlName = "Uniform";
	}

	public void setXmlName(String name) {
	//		xmlName = name;
	}

	public String getXmlName() {
		return xmlName;
	}
}	
