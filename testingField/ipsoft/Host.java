import javax.xml.*;
import javax.xml.bind.annotation.*;

@XmlRootElement
public class Host {

	String Host_Name;
	String IP_address;
	String OS;
	String Load_avg_1min;
	String Load_avg_5min;
	String Load_avg_15min;

	public Host () {
		Host_Name = "default";
		IP_address = "default";
		OS = "default";
		Load_avg_1min = "default";
		Load_avg_5min = "default";
		Load_avg_15min = "default";
	}

	public void setHost_Name(String input) {
		Host_Name = input;
	}

	public String getHost_Name() {
		return this.Host_Name;
	}
	
	public void setIP_address(String input) {
		IP_address = input;
	}

	public String getIP_address() {
		return this.IP_address;
	}

	public void setOS(String input) {
		OS = input;
	}

	public String getOS() {
		return this.OS;
	}

	public void setLoad_avg_1min(String input) {
		Load_avg_1min = input;
	}

	public String getLoad_avg_1min() {
		return this.Load_avg_1min;
	}

	public void setLoad_avg_5min(String input) {
		Load_avg_5min = input;
	}

	public String getLoad_avg_5min() {
		return this.Load_avg_5min;
	}

	public void setLoad_avg_15min(String input) {
		Load_avg_15min = input;
	}

	public String getLoad_avg_15min() {
		return this.Load_avg_15min;
	}
}
