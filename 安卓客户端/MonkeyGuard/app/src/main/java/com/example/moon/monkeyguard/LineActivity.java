package com.example.moon.monkeyguard;

import android.opengl.GLSurfaceView;
import android.opengl.GLU;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.opengl.GLSurfaceView.Renderer;
import android.view.TextureView;
import android.view.WindowManager;

import java.nio.ByteBuffer;
import java.nio.ByteOrder;
import java.nio.FloatBuffer;
import java.nio.ShortBuffer;
import java.security.acl.Group;

import javax.microedition.khronos.egl.EGLConfig;
import javax.microedition.khronos.opengles.GL10;

public class LineActivity extends AppCompatActivity{
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_line);
    }
}
