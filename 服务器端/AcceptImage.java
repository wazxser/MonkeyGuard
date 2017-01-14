import java.io.BufferedWriter;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.net.ServerSocket;
import java.net.Socket;
import java.nio.charset.Charset;

import org.json.JSONArray;
import org.json.JSONObject;

import com.facepp.error.FaceppParseException;
import com.facepp.http.HttpRequests;
import com.facepp.http.PostParameters;

public class AcceptImage {
	static int i = 0;

	public static void main(String [] args) throws IOException{
		ServerSocket server = new ServerSocket(9527);
		
		HttpRequests httpRequests = new HttpRequests("3e3054f2a97a84164cfb6a93eeb5a13e", "JWuDhMOui7iQuhPi0GcAGnZfquDSbSks", true, true);
		JSONObject result = null;
		
		while(true){
			File f1 = new File("/var/www/html/faceTestImg/");
			String [] str1 = f1.list();
			int num1 = str1.length;
			
			AcceptImage(server);
			
			File f2 = new File("/var/www/html/faceTestImg/");
			String [] str2 = f2.list();
			int num2 = str2.length;
			
			if(num2 > num1){
				try{
					System.out.println(Charset.forName("UTF-8").name());
					result = httpRequests.detectionDetect(new PostParameters().setUrl("http://115.29.109.27/faceTestImg/" + i + ".jpg"));
					
					JSONArray face = result.getJSONArray("face");
										
					System.out.println(face);

					if(face.length() != 0){
						File txt = new File("./store.txt");
						txt.createNewFile();
						BufferedWriter txtOut = new BufferedWriter(new FileWriter(txt));
						txtOut.write("cniwniubveib");
						txtOut.flush();
						txtOut.close();
					}
					else{
						System.out.println("no face");
					}
				}
				catch(FaceppParseException e){
					e.printStackTrace();
				} catch (Exception e) {
					e.printStackTrace();
				}
			}
		}
	}
	
	public static void AcceptImage(ServerSocket server){
		try {
			Socket socket1 = server.accept();
			InputStream in = socket1.getInputStream();
			File file = new File("/var/www/html/faceTestImg/");
			String [] f = file.list();

			i = f.length;

			File fi = new File("/var/www/html/faceTestImg/" + i + ".jpg");
			fi.createNewFile();

			FileOutputStream fos = new FileOutputStream("/var/www/html/faceTestImg/" + i + ".jpg");

			byte[] data = new byte[10240];
			int len = 0;

			while((len = in.read(data)) != -1){
				fos.write(data, 0, len);
			}

			OutputStream out = socket1.getOutputStream();
			out.write("success".getBytes());
			
			in.close();
			fos.close();
			out.close();
			socket1.close();
		} catch (IOException e) {
			e.printStackTrace();
		}
	}
}
