package Paint;

import java.awt.FlowLayout;
import java.awt.event.ActionListener;
import java.awt.event.MouseListener;
import java.awt.event.MouseMotionListener;

public class DukePaint extends javax.swing.JPanel implements ActionListener, MouseListener, MouseMotionListener
{
  private static final int WIDTH = 800;
  private static final int HEIGHT = 400;
  java.util.ArrayList<SimpleShape> shapes = new java.util.ArrayList();
  SimpleShape shape;
  javax.swing.JFrame frame = new javax.swing.JFrame("画板");
  javax.swing.JPanel pTop = new javax.swing.JPanel();
  javax.swing.JComboBox<String> cmbShape = new javax.swing.JComboBox((String[])shapeNames.toArray());
  javax.swing.JComboBox<String> cmbColor = new javax.swing.JComboBox((String[])colorNames.toArray());
  javax.swing.JButton btnClear = new javax.swing.JButton("清除内容");
  javax.swing.JButton btnUndo = new javax.swing.JButton("撤销");
  
  private boolean drawingOn = false;
  
  static java.util.List<Class<? extends SimpleShape>> shapeTypes = java.util.Collections.unmodifiableList(
    java.util.Arrays.asList(new Class[] { Line.class, Circle.class, Rect.class, Profile.class }));
  
  static java.util.List<String> shapeNames = java.util.Collections.unmodifiableList(java.util.Arrays.asList(new String[] { "直线", "椭圆", "矩形", "曲线" }));
  static java.util.List<String> colorNames = java.util.Collections.unmodifiableList(java.util.Arrays.asList(new String[] { "黑色", "蓝色", "青色", "暗灰", "灰色", "绿色", "亮灰", "洋红", "桔黄", "粉红", "红色", "白色", "黄色" }));
  
  static java.util.List<java.awt.Color> colorTypes = java.util.Collections.unmodifiableList(java.util.Arrays.asList(new java.awt.Color[] { java.awt.Color.black, java.awt.Color.blue, java.awt.Color.cyan, java.awt.Color.darkGray, java.awt.Color.gray, java.awt.Color.green, java.awt.Color.lightGray, java.awt.Color.magenta, java.awt.Color.orange, java.awt.Color.pink, java.awt.Color.red, java.awt.Color.white, java.awt.Color.yellow }));
  
  static java.util.Map<String, java.awt.Color> mapColor = new java.util.HashMap();
  static java.util.Map<String, Class<? extends SimpleShape>> mapShape = new java.util.HashMap();
  
  static
  {
    for (int i = 0; i < shapeTypes.size(); i++)
    {
      mapShape.put(shapeNames.get(i), shapeTypes.get(i));
    }
    for (i = 0; i < colorNames.size(); i++)
    {
      mapColor.put(colorNames.get(i), colorTypes.get(i));
    }
  }
  
  public DukePaint()
  {
    this.frame.setSize(800, 400);
    this.frame.setResizable(false);
    this.frame.setBackground(java.awt.Color.white);
    this.frame.setDefaultCloseOperation(3);
    this.frame.setLocationRelativeTo(null);
    
    this.pTop.setLayout(new FlowLayout());
    this.pTop.add(new javax.swing.JLabel("形状"));
    this.pTop.add(this.cmbShape);
    this.pTop.add(new javax.swing.JLabel("颜色"));
    this.pTop.add(this.cmbColor);
    this.pTop.add(this.btnUndo);
    this.pTop.add(this.btnClear);
    this.frame.add(this.pTop, "North");
    
    java.awt.Color localColor = new java.awt.Color(1.0F, 1.0F, 1.0F);
    setBackground(localColor);
    this.frame.add(this, "Center");
    
    this.btnClear.addActionListener(this);
    this.btnUndo.addActionListener(this);
    addMouseListener(this);
    addMouseMotionListener(this);
    this.frame.setVisible(true);
    new DukePaint.PaintThread(null).start();
  }
  
  private void clearPaintBoard() {
    this.shapes.clear();
    this.shape = null;
  }
  
  private void undo() {
    if (this.shapes.size() == 0) return;
    this.shapes.remove(this.shapes.size() - 1);
  }
  
  public static void main(String... paramVarArgs) {
    new DukePaint();
  }
  
  public void actionPerformed(java.awt.event.ActionEvent paramActionEvent)
  {
    Object localObject = paramActionEvent.getSource();
    if (localObject == this.btnClear)
    {
      clearPaintBoard();
    }
    else if (localObject == this.btnUndo)
    {
      undo();
    }
  }
  
  public void mousePressed(java.awt.event.MouseEvent paramMouseEvent)
  {
    java.awt.Point localPoint = new java.awt.Point(paramMouseEvent.getX(), paramMouseEvent.getY());
    java.awt.Color localColor = (java.awt.Color)mapColor.get((String)this.cmbColor.getSelectedItem());
    String str = (String)this.cmbShape.getSelectedItem();
    Class localClass = (Class)mapShape.get(str);
    
    try
    {
      this.shape = ((SimpleShape)localClass.newInstance());
      this.shape.setColor(localColor);
      this.shape.setP1(localPoint);
      this.drawingOn = true;
    }
    catch (Exception localException)
    {
      localException.printStackTrace();
    }
  }
  
  public void mouseReleased(java.awt.event.MouseEvent paramMouseEvent)
  {
    java.awt.Point localPoint = new java.awt.Point(paramMouseEvent.getX(), paramMouseEvent.getY());
    this.shape.setP2(localPoint);
    this.shapes.add(this.shape);
    this.drawingOn = false;
  }
  
  public void mouseDragged(java.awt.event.MouseEvent paramMouseEvent)
  {
    if (!this.drawingOn) return;
    java.awt.Point localPoint = new java.awt.Point(paramMouseEvent.getX(), paramMouseEvent.getY());
    this.shape.setP2(localPoint);
  }
  
  public void paintComponent(java.awt.Graphics paramGraphics)
  {
    super.paintComponent(paramGraphics);
    if (this.drawingOn) this.shape.draw(paramGraphics);
    for (SimpleShape localSimpleShape : this.shapes)
    {
      localSimpleShape.draw(paramGraphics); }
  }
  
  public void mouseClicked(java.awt.event.MouseEvent paramMouseEvent) {}
  
  public void mouseEntered(java.awt.event.MouseEvent paramMouseEvent) {}
  
  private class PaintThread extends Thread { private PaintThread() {}
    
    public void run() { for (;;) { DukePaint.this.repaint();
        try
        {
          Thread.sleep(120L);
        }
        catch (InterruptedException localInterruptedException)
        {
          localInterruptedException.printStackTrace();
        }
      }
    }
  }
  
  public void mouseExited(java.awt.event.MouseEvent paramMouseEvent) {}
  
  public void mouseMoved(java.awt.event.MouseEvent paramMouseEvent) {}
}
