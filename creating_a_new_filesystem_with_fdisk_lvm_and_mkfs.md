
# How to Manage Disk Space on VMware Linux Virtual Machines

**Power off the VM and expand the VMDK from the VM’s settings. Power the VM back on again.**

#### Good Refs
* https://drive.google.com/drive/u/1/folders/1CjB_Uq59E3dI0veVCQHgh5cXh4iHSbWB
* https://www.thegeekstuff.com/2010/09/vmware-esxi-add-virtual-disk/
* https://www.altaro.com/vmware/managing-disk-space-linux-vm/
* https://www.tecmint.com/create-new-ext4-file-system-partition-in-linux/

#### Other Refs
* https://www.howtogeek.com/howto/40702/how-to-manage-and-use-lvm-logical-volume-management-in-ubuntu
* https://www.cyberciti.biz/tips/vmware-add-a-new-hard-disk-without-rebooting-guest.html
* http://bencane.com/2011/12/19/creating-a-new-filesystem-with-fdisk-lvm-and-mkfs
* http://www.ovaistariq.net/638/on-lvm-how-to-setup-volume-groups-and-logical-volumes

Managing disk space on a VMware Linux VM, such as expanding existing drives, can turn out to be a complicated matter if Linux is not your thing. With Windows, it’s a simple matter of creating or expanding a VMDK and you’re a couple of clicks away from completing the task. Sadly, it’s not so simple with Linux. You need to factor in the Linux flavor, the file system type, whether LVM is used or not, mount points, boot persistence and so on.

In today’s topic, we’ll explore how to manage disk space on a Linux VM. I’ll be using a Centos VM as a test case to which I’ll add a second disk and expand it at a later stage. I chose not to use LVM selecting ext4 as the file system to keep things simple. Having said that, LVM has some major benefits, so do your homework when selecting a filesystem for Linux.

Throughout this post, I’m using the vSphere Web client that comes installed with vCenter Server 6.5.

# A. How to ADD a New Virtual Hard Disk to a Linux Centos VM

**Power off the VM and expand the VMDK from the VM’s settings. Power the VM back on again.**

## Step 1: vSphere Client - How to Add a new Virtual Hard Disk (from Datastore) to a VM Using vSphere Client
If you are a sysadmin, who is responsible for managing multiple servers, you should learn the fundamentals of virtualization and implement it in your environment.
On a very high-level, you should get started by installing VMWare ESXi server, which can be managed using vSphere Client.
Using vSphere client, you can create several virtual machines.
If you have multiple hard drives installed on the server, you should first create a datastore.
Once a datastore is created, you can assign either full or part of the datastore’s storage to a virtual machine as explained in this article.
### 1. Add Hardware – Device Type (Hard Disk)
Increasing the size of a VMDK in vSphere Web client

![Increasing the size of a VMDK in vSphere Web client](https://s25967.pcdn.co/vmware/wp-content/uploads/2017/06/062617_0926_Howtoadddis12.png)

Add the new hard disk (VMDK) from the VM’s settings. As per the next screenshot, I’ve created a 500GB drive which is thick provisioned and residing on an iSCSI datastore.

Click on “Add” button located at the top of the “Hardware” tab in the virtual machine properties dialogue, which will display the following add hardware wizard. Select Hard Disk and click Next.

![Datastores](https://drive.google.com/uc?id=1eRXKxcZCIqExYTSo_c-QQ5xv5SGgWkQX&export=download)

I will be used 500GB from Datastore 1 (2TB)
![Datastore 1](https://drive.google.com/uc?id=1sQEYr5f1PjDGSgGZoMtNX8ZhkA2j0aJy&export=download)

Create Folder to store VM Disk in next step 
![VM Disk storage](https://drive.google.com/uc?id=1ADl9uvokLQOzEeiZNRl7QVuxmzdX52Hc&export=download)

Add New VM Disk from Datastore1 2TB
![Add New VM Disk from Datastore1 2TB](https://drive.google.com/uc?id=12FFZqVY3Wgqdrg7IhKruxzl-4dDMZKN8&export=download)

### 2. Review New Disk Space for VM
Once the datastore is created, Click on a specific virtual machine name from the left tree -> “Summary” Tab -> Under the “Resources” section in summary tab, it will display that the provisioned size is 135 GB. Initially from step#1 above, it showed 24 GB. Now this shows the new virtual disk added to this virtual machine.

Reboot the virtual machine, for your operating system to pick-up this newly created disk space. If your previous disk is /dev/sda, this new disk will be /dev/sdb. You should partition and format this new /dev/sdb using fdisk mkfs command.

![Review New Disk Space for VM 500GB](https://drive.google.com/uc?id=12FFZqVY3Wgqdrg7IhKruxzl-4dDMZKN8&export=download)

### 3. Reboot
Reboot to scan for new drives

## Step 2: Centost 7 SSH Console - How to add a new disk to a Linux Centos VM
### 1. Console to the VM 
Console to the VM or SSH to it using `putty` or similar. Log in as `root` or one with similar privileges.
### 2. Run ls /dev/sd*
Run `ls /dev/sd*` to list the disks and associated partitions. Ideally, you’d do this prior to creating the new disk so you can compare outputs later. This allows you to easily spot the name of the new device. In my case, I began with one disk `sda` partitioned as `sda1` and `sda2`. Given the next screenshot, this means that `sdb` is the newly added drive
TIP: You can add and scan for new drives without the need to reboot the VM. To do this, run the following commands.

```
[root@vswb ~]# ls -al /dev/sd*
brw-rw----. 1 root disk 8,  0 Oct 27 22:27 /dev/sda
brw-rw----. 1 root disk 8,  1 Oct 27 22:27 /dev/sda1
brw-rw----. 1 root disk 8,  2 Oct 27 22:27 /dev/sda2
brw-rw----. 1 root disk 8, 16 Oct 27 22:44 **/dev/sdb**
```

```
root@vswb ~]# fdisk -l

Disk /dev/sdb: 536.9 GB, 536870912000 bytes, 1048576000 sectors
Units = sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes

Disk /dev/sda: 429.5 GB, 429496729600 bytes, 838860800 sectors
Units = sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
Disk label type: dos
Disk identifier: 0x000af2bc

   Device Boot      Start         End      Blocks   Id  System
/dev/sda1   *        2048     2099199     1048576   83  Linux
/dev/sda2         2099200   838860799   418380800   8e  Linux LVM

Disk /dev/mapper/centos_vswb-root: 96.6 GB, 96636764160 bytes, 188743680 sectors
Units = sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes

Disk /dev/mapper/centos_vswb-swap: 8455 MB, 8455716864 bytes, 16515072 sectors
Units = sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes

Disk /dev/mapper/centos_vswb-home: 323.3 GB, 323322118144 bytes, 631488512 sectors
Units = sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
```

### 3. Run fdisk /dev/sdb to verify
Just to be sure that we got the correct drive, run `fdisk /dev/sdb` to verify that it has no partitions as per the device does not contain a recognized partition table message. Note that there are instances where a disk in use `does not have any partitions` so try something like `df -h` to see if the drive is in use.

- Type **n** and press **Enter**.
- Type **p** and press **Enter**.
- Type **1** and press **Enter**.
- Press **Enter** to accept the default first sector.
- Press **Enter** to accept the default last sector.
- Type **w** and press **Enter** to write the changes to disk. You should now have a new partition called sdb1.

**See below:**

```
[root@vswb ~]# fdisk /dev/sdb 
Welcome to fdisk (util-linux 2.23.2).

Changes will remain in memory only, until you decide to write them.
Be careful before using the write command.

Device does not contain a recognized partition table
Building a new DOS disklabel with disk identifier 0xd5f2c3a8.

Command (m for help): n
Partition type:
   p   primary (0 primary, 0 extended, 4 free)
   e   extended
Select (default p): p       <--------- p and enter
Partition number (1-4, default 1): 1       <--------- 1 and enter
First sector (2048-1048575999, default 2048):        <--------- enter
Using default value 2048
Last sector, +sectors or +size{K,M,G} (2048-1048575999, default 1048575999):       <--------- enter 
Using default value 1048575999
Partition 1 of type Linux and of size 500 GiB is set

Command (m for help): w       <--------- 1w and enter
The partition table has been altered!

Calling ioctl() to re-read partition table.
Syncing disks.
```
```
[root@vswb ~]# ls -al /dev/sd*
brw-rw----. 1 root disk 8,  0 Oct 27 22:27 /dev/sda
brw-rw----. 1 root disk 8,  1 Oct 27 22:27 /dev/sda1
brw-rw----. 1 root disk 8,  2 Oct 27 22:27 /dev/sda2
brw-rw----. 1 root disk 8, 16 Oct 27 22:44 /dev/sdb
brw-rw----. 1 root disk 8, 17 Oct 27 22:44 **/dev/sdb1**
```

### 4. Format the newly created partition using the ext4 filesystem
Run `mkfs.ext4 -L /media/disk2 /dev/sdb1` to format the newly created partition using the `ext4` filesystem. You can use `mkfs.ext3` instead, if you prefer.

```
[root@vswb ~]# mkfs.ext4 --help

mkfs.ext4: invalid option -- '-'
Usage: mkfs.ext4 [-c|-l filename] [-b block-size] [-C cluster-size]
	[-i bytes-per-inode] [-I inode-size] [-J journal-options]
	[-G flex-group-size] [-N number-of-inodes]
	[-m reserved-blocks-percentage] [-o creator-os]
	[-g blocks-per-group] [-L volume-label] [-M last-mounted-directory]
	[-O feature[,...]] [-r fs-revision] [-E extended-option[,...]]
	[-t fs-type] [-T usage-type ] [-U UUID] [-jnqvDFKSV] device [blocks-count]
```
```
[root@vswb ~]# mkfs.ext4 -L hdd-500gb /dev/sdb1
mke2fs 1.42.9 (28-Dec-2013)
Filesystem label=hdd-500gb
OS type: Linux
Block size=4096 (log=2)
Fragment size=4096 (log=2)
Stride=0 blocks, Stripe width=0 blocks
32768000 inodes, 131071744 blocks
6553587 blocks (5.00%) reserved for the super user
First data block=0
Maximum filesystem blocks=2279604224
4000 block groups
32768 blocks per group, 32768 fragments per group
8192 inodes per group
Superblock backups stored on blocks: 
	32768, 98304, 163840, 229376, 294912, 819200, 884736, 1605632, 2654208, 
	4096000, 7962624, 11239424, 20480000, 23887872, 71663616, 78675968, 
	102400000

Allocating group tables: done                            
Writing inode tables: done                            
Creating journal (32768 blocks): done
Writing superblocks and filesystem accounting information: done
```


**Important Note**: Alternatively, using an mkfs tool, a disk can be formatted with the required file system without actually creating a partition. To do this, run `mkfs.ext4 -L /media/disk2 /dev/sdb`. The `-L` parameter specifies the label that is assigned to drive while **/dev/sdb** is the drive we’re targeting. Press Y to acknowledge use of the whole drive. **Again, I don’t suggest doing this unless absolutely necessary** ...


### 5. Mount the newly added drive
Next, create a folder (mount point) so we can mount the newly added drive to it. Run `mkdir hdd-500gb` followed by mount `/dev/sdb1/hdd-500gb`. Note: The folder name `hdd-500gb` is arbitrary. Call it what you want.

```
[root@vswb ~]# mkdir -p /media/disk2
[root@vswb ~]# mount /dev/sdb1 /media/disk2
[root@vswb ~]# ls -al /media/disk2/
total 20
drwxr-xr-x. 3 root root  4096 Oct 27 22:56 .
drwxr-xr-x. 3 root root    23 Oct  6 23:28 ..
drwx------. 2 root root 16384 Oct 27 22:56 lost+found
```

### 6. The mount point to persist reboots
We want the mount point to persist **reboots**. Adding it as an entry in `/etc/fstab` as shown, achieves this. Use vi or another text editor, add the line to `fstab`.

```
[root@vswb ~]# vi /etc/fstab
```
```
#
# /etc/fstab
# Created by anaconda on Fri Sep 13 15:58:18 2019
#
# Accessible filesystems, by reference, are maintained under '/dev/disk'
# See man pages fstab(5), findfs(8), mount(8) and/or blkid(8) for more info
#
/dev/mapper/centos_vswb-root /                       xfs     defaults        0 0
UUID=60ef3fd8-f835-4540-8942-24a057a108ac /boot                   xfs     defaults        0 0
/dev/mapper/centos_vswb-home /home                   xfs     defaults        0 0
/dev/mapper/centos_vswb-swap swap                    swap    defaults        0 0
/dev/sdb1/  /media/disk2  ext4    defaults    0 0
```

### 7. The next two steps are optional, final testing
**The next two steps are optional**. It’s just to verify that the drive mounted correctly and is **writable**. The output from `mount | grep sdb1` confirms this much as does `df -h` where the line `/dev/sdb1` tells us that the drive is mounted along with the available and remaining disk space.

```
[root@vswb ~]# mount | grep sdb
/dev/sdb1 on /media/disk2 type ext4 (rw,relatime,seclabel,data=ordered)
```
```
[root@vswb ~]# cd /media/disk2/
[root@vswb hdd-500gb]# echo "This is a log file to test new hard disk" > out.log
[root@vswb hdd-500gb]# ls -al
total 32
drwxr-xr-x. 5 root root  4096 Oct 27 23:10 .
drwxr-xr-x. 3 root root    23 Oct  6 23:28 ..
drwx------. 2 root root 16384 Oct 27 22:56 lost+found
-rw-r--r--. 1 root root    41 Oct 27 23:10 out.log
```
```
[root@vswb ~]# fdisk -l

Disk /dev/sda: 429.5 GB, 429496729600 bytes, 838860800 sectors
Units = sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
Disk label type: dos
Disk identifier: 0x000af2bc

   Device Boot      Start         End      Blocks   Id  System
/dev/sda1   *        2048     2099199     1048576   83  Linux
/dev/sda2         2099200   838860799   418380800   8e  Linux LVM

Disk /dev/sdb: 536.9 GB, 536870912000 bytes, 1048576000 sectors
Units = sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
Disk label type: dos
Disk identifier: 0xd5f2c3a8

   Device Boot      Start         End      Blocks   Id  System
/dev/sdb1            2048  1048575999   524286976   83  Linux

Disk /dev/mapper/centos_vswb-root: 96.6 GB, 96636764160 bytes, 188743680 sectors
Units = sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes

Disk /dev/mapper/centos_vswb-swap: 8455 MB, 8455716864 bytes, 16515072 sectors
Units = sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes

Disk /dev/mapper/centos_vswb-home: 323.3 GB, 323322118144 bytes, 631488512 sectors
Units = sectors of 1 * 512 = 512 bytes
Sector size (logical/physical): 512 bytes / 512 bytes
I/O size (minimum/optimal): 512 bytes / 512 bytes
```
```
[root@vswb ~]# df -h
Filesystem                    Size  Used Avail Use% Mounted on
devtmpfs                      7.8G     0  7.8G   0% /dev
tmpfs                         7.8G  8.0K  7.8G   1% /dev/shm
tmpfs                         7.8G  9.0M  7.8G   1% /run
tmpfs                         7.8G     0  7.8G   0% /sys/fs/cgroup
/dev/mapper/centos_vswb-root   90G   20G   70G  23% /
/dev/sdb1                     493G   73M  467G   1% /media/disk2
/dev/sda1                    1014M  262M  753M  26% /boot
/dev/mapper/centos_vswb-home  301G   28G  274G  10% /home
tmpfs                         1.6G     0  1.6G   0% /run/user/991
tmpfs                         1.6G     0  1.6G   0% /run/user/990
tmpfs                         1.6G     0  1.6G   0% /run/user/0
```

# B. How to EXPAND a disk on a Centos Linux VM
**Power off the VM and expand the VMDK from the VM’s settings. Power the VM back on again.**

A 1GB drive won’t cut it, so we will expand it to 4GB. There are a few choices you could go for. You could, temporarily, move data from the existing partition to another disk, delete and re-create it from scratch and then expand it. You could also use the gparted utility to increase the partition size without deleting anything. Alternatively, you can simply add a second partition to the disk.

**IMPORTANT: Stop now and take a backup if you’re doing this on a production system.**


## Step 1: vSphere Client - How to Add a new Virtual Hard Disk (from Datastore) to a VM Using vSphere Client
**Please do the same A.Step 1**
Increasing the size of a VMDK in vSphere Web client

![Increasing the size of a VMDK in vSphere Web client](https://s25967.pcdn.co/vmware/wp-content/uploads/2017/06/062617_0926_Howtoadddis12.png)

## Step 2: Centost 7 SSH Console - How to add a new disk to a Linux Centos VM
### 2 – Unmount the drive 
Unmount the drive by running `umount /dev/sdb1`

![Unmount](https://s25967.pcdn.co/vmware/wp-content/uploads/2017/06/062617_0926_Howtoadddis13.png)

### 3 – Using fdisk, 
Using fdisk, delete the primary partition and create again it from scratch using the procedure outlined in step `A.Step2.3` above.

**Note**: If the partition table size remains the same, data on the disk will be preserved. If you have multiple partitions, do take a note of the starting and ending sectors making sure to keep them the same when re-creating the partition(s).

![](https://s25967.pcdn.co/vmware/wp-content/uploads/2017/06/062617_0926_Howtoadddis14.png)

![](https://s25967.pcdn.co/vmware/wp-content/uploads/2017/06/062617_0926_Howtoadddis15.png)
 

### 4 – Remount the partition
Remount the partition – `mount /dev/sdb1 //media/disk2` – and run `resize2fs /dev/sdb1` to resize it.

### 5 – Run df -h to verify 
Run `df -h` to verify that the drive is correctly sized and that pre-existing data has been retained; just `cd` to it and `ls`.

Checking disk space utilization via the df command in Linux

![](https://s25967.pcdn.co/vmware/wp-content/uploads/2017/06/062617_0926_Howtoadddis16.png)

 
**Conclusion**
We’ve seen how you can quickly add and expand disks on Linux VMs. One thing you should keep in mind, however, is that the procedures outlined in this post may differ according to the Linux distro in use along with a number of other factors. That said, there’s a ton of information out there explaining how to manage storage on Linux. Regardless of the distro used, do yourself a favor and always take a backup or snapshot of the VM before playing around with disk management.