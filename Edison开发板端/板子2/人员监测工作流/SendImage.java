import java.io.DataOutputStream;
import java.io.FileInputStream;
import java.net.Socket;

import org.omg.CORBA.portable.InputStream;
import org.omg.CORBA.portable.OutputStream;

public class SendImage {
	public static void main(String[] args) throws Exception{
		String path = System.getProperty("user.dir");
    	System.out.println(path);
		Socket s = new Socket("192.168.252.3", 9527);
		  //FileInputStream fis = new FileInputStream(path + "\\src\\ImageSocketServer\\images\\image.jpg");
		  FileInputStream fis = new FileInputStream("./image.jpg");

		  java.io.OutputStream out = s.getOutputStream();
		  byte [] buf = new byte[1024];
		  int len = 0;
		  while ((len = fis.read(buf)) != -1)
		  {
		   out.write(buf, 0, len);
		  }
		  s.shutdownOutput();  //ÉÏ´«Íê±Ï
		  
		  java.io.InputStream in = s.getInputStream();
		  byte [] bufin = new byte[1024];
		  int lenin = in.read(bufin);
		  System.out.println(new String(bufin,0,lenin));
		  
		  fis.close();
		  s.close();
	}
}
